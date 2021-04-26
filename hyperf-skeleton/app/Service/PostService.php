<?php


namespace App\Service;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Job\PostIncreaseReadJob;
use App\Job\PostMachineAuditJob;
use App\Job\UniqueJobQueue;
use App\Model\Post;
use App\Model\PostDraft;
use App\Model\ReportPost;
use App\Model\User;
use App\Model\UserFavorite;
use App\Model\UserRead;
use App\Model\UserVote;
use App\Model\Vote;
use App\Model\VoteItem;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Facade\Auth;
use ZYProSoft\Log\Log;
use Hyperf\Di\Annotation\Inject;

class PostService extends BaseService
{
    /**
     * @Inject
     * @var UniqueJobQueue
     */
    private UniqueJobQueue $queueService;

    private array $listRows = [
        'post_id',
        'title',
        'summary',
        'owner_id',
        'image_list',
        'link',
        'vote_id',
        'read_count',
        'forward_count',
        'comment_count',
        'audit_status',
        'is_hot',
        'last_comment_time',
        'sort_index',
        'is_recommend',
        'created_at',
        'updated_at',
        'join_user_count',
        'avatar_list'
    ];

    //重载获取当前用户ID的方法
    protected function userId()
    {
        //当前用户是不是管理员
        if (Auth::isGuest()) {
            return Auth::userId();
        }
        $userId = Auth::userId();
        $user = User::find($userId);
        if ($user->role_id == Constants::USER_ROLE_ADMIN) {
            //检查是不是在使用化身
            if ($user->avatar_user_id > 0) {
                Log::info("使用化身($user->avatar_user_id)");
                return $user->avatar_user_id;
            }
        }
        return $userId;
    }

    public function create(array $params)
    {
        $post = null;
        $imageAuditCheck = [
            'need_audit' => false,
            'need_review' => false
        ];
        Db::transaction(function () use ($params, &$post, &$imageAuditCheck) {
            $title = $params['title'];
            $content = $params['content'];
            $link = data_get($params, 'link');
            $imageList = data_get($params, 'imageList');
            $vote = data_get($params, 'vote');
            $programId = data_get($params,'programId');
            $accountId = data_get($params,'accountId');

            $post = new Post();
            $post->owner_id = $this->userId();
            $post->title = $title;
            if (mb_strlen($content) < 40) {
                $post->summary = $content;
            } else {
                $post->summary = mb_substr($content, 0, 40);
            }
            $post->content = $content;
            if(isset($programId)) {
                $post->program_id = $programId;
            }
            if(isset($accountId)) {
                $post->account_id = $accountId;
            }
            if (isset($imageList)) {
                if (!empty($imageList)) {
                    $post->image_list = implode(';', $imageList);
                    $imageIds = $this->imageIdsFromUrlList($imageList);
                    $post->image_ids = implode(';',$imageIds);
                    //检测上传图片
                    $imageAuditCheck = $this->auditImageOrFail($imageList,true);
                }
            }
            if (isset($link)) {
                $post->link = $link;
            }

            if (isset($vote)) {
                $subject = $vote['subject'];
                $items = collect($vote['items']);
                $vote = new Vote();
                $vote->title = $subject;
                $vote->saveOrFail();
                $items->map(function (array $item) use ($vote) {
                    $voteItem = new VoteItem();
                    $voteItem->content = $item['content'];
                    $voteItem->vote_id = $vote->vote_id;
                    $voteItem->saveOrFail();
                });
                $post->vote_id = $vote->vote_id;
            }
            //审核结果
            Log::info("图片审核结果:".json_encode($imageAuditCheck));
            if($imageAuditCheck['need_review']) {
                $post->machine_audit = Constants::STATUS_REVIEW;
            }
            $post->saveOrFail();
        });

        if (!isset($post)) {
            throw new HyperfCommonException(ErrorCode::SERVER_ERROR, '发布帖子失败');
        }

        //机器审核结果是需要人工继续审核就不需要自动审核任务了
        if($post->machine_audit !== Constants::STATUS_REVIEW) {
            Log::info("增加帖子($post->post_id)自动审核任务");
            $this->push(new PostMachineAuditJob($post->post_id));
        }else{
            Log::info("帖子($post->post_id)需要转人工审核");
        }

        return $this->success($post);
    }

    public function delete(int $postId)
    {
        $this->checkOwnOrFail($postId);
        Post::findOrFail($postId)->delete();
        return $this->success();
    }

    public function checkOwn(int $postId)
    {
        $post = Post::query()->where('post_id', $postId)
            ->where('owner_id', $this->userId())
            ->first();
        if ($post instanceof Post) {
            return $post;
        }
        return false;
    }

    public function checkOwnOrFail(int $postId)
    {
        $post = $this->checkOwn($postId);
        if ($post === false) {
            throw new HyperfCommonException(ErrorCode::NOT_OWN_BY_CURRENT_USER);
        }
        return $post;
    }

    public function update(int $postId, array $params)
    {
        $post = null;
        $post = $this->checkOwnOrFail($postId);
        $imageAuditCheck = [
            'need_audit' => false,
            'need_review' => false
        ];
        if (isset($params['title'])) {
            $post->title = $params['title'];
        }
        if(isset($params['programId'])) {
            $post->program_id = $params['programId'];
        }
        if(isset($params['accountId'])) {
            $post->account_id = $params['accountId'];
        }
        if (isset($params['imageList'])) {
            $post->image_list = implode(';', $params['imageList']);
            if (!empty($imageList)) {
                $post->image_list = implode(';', $imageList);
                $imageIds = $this->imageIdsFromUrlList($imageList);
                $post->image_ids = implode(';',$imageIds);
                //检测上传图片
                $imageAuditCheck = $this->auditImageOrFail($imageList);
            }
        }
        if (isset($params['link'])) {
            $post->link = $params['link'];
        }
        if (isset($params['content'])) {
            $post->content = $params['content'];
        }
        $post->audit_status = 0;//恢复待审核
        //审核结果
        Log::info("图片审核结果:".json_encode($imageAuditCheck));
        if($imageAuditCheck['need_review']) {
            $post->machine_audit = Constants::STATUS_REVIEW;
        }
        $post->saveOrFail();

        //机器审核结果是需要人工继续审核就不需要自动审核任务了
        if($post->machine_audit !== Constants::STATUS_REVIEW) {
            Log::info("增加帖子($post->post_id)自动审核任务");
            $this->push(new PostMachineAuditJob($post->post_id));
        }else{
            Log::info("帖子($post->post_id)需要转人工审核");
        }

        return $this->success($post);
    }

    public function detail(int $postId)
    {
        $post = Post::query()->where('post_id', $postId)
            ->with(['vote','mini_program','official_account'])
            ->first();
        if (!$post instanceof Post) {
            throw new HyperfCommonException(ErrorCode::POST_NOT_EXIST);
        }
        if(!empty($post->image_list)) {
            $post->image_list = explode(';', $post->image_list);
        }
        if (Auth::isGuest() == false) {
            //投票状态
            $userVote = UserVote::query()->where('user_id', $this->userId())
                ->where('post_id', $postId)
                ->first();
            if ($userVote instanceof UserVote) {
                $post->is_voted = 1;
            } else {
                $post->is_voted = 0;
            }
            //阅读状态
            $userRead = UserRead::query()->where('user_id', $this->userId())
                ->where('post_id', $postId)
                ->first();
            if ($userRead instanceof UserRead) {
                $post->is_read = 1;
            } else {
                $post->is_read = 0;
            }
            //收藏状态
            $userFavorite = UserFavorite::query()->where('user_id', $this->userId())
                ->where('post_id', $postId)
                ->first();
            if ($userFavorite instanceof UserFavorite) {
                $post->is_favorite = 1;
            } else {
                $post->is_favorite = 0;
            }
        } else {
            $post->is_read = 0;
            $post->is_voted = 0;
            $post->is_favorite = 0;
        }

        //增加阅读数
        $this->push(new PostIncreaseReadJob($postId));

        return $post;
    }

    public function vote(int $voteItemId, int $postId, int $voteId)
    {
        $userVote = UserVote::query()->where('post_id', $postId)
            ->where('user_id', $this->userId())
            ->first();
        if ($userVote instanceof UserVote) {
            throw new HyperfCommonException(ErrorCode::DO_NOT_REPEAT_ACTION);
        }
        Db::transaction(function () use ($voteItemId, $postId, $voteId) {
            VoteItem::find($voteItemId)->increment('user_count');
            $userVote = new UserVote();
            $userVote->user_id = $this->userId();
            $userVote->post_id = $postId;
            $userVote->saveOrFail();
            $vote = Vote::findOrFail($voteId);
            $vote->increment('total_user');
        });
        return $this->success();
    }

    public function voteDetail(int $voteId)
    {
        return Vote::query()->where('vote_id', $voteId)
            ->firstOrFail();
    }

    public function getList(int $sortType, int $pageIndex, int $pageSize)
    {
        $map = [
            Constants::POST_SORT_TYPE_LATEST => 'created_at',
            Constants::POST_SORT_TYPE_LATEST_REPLY => 'last_comment_time',
            Constants::POST_SORT_TYPE_REPLY_COUNT => 'comment_count'
        ];
        $order = $map[$sortType];
        switch ($sortType) {
            case Constants::POST_SORT_TYPE_LATEST:
            case Constants::POST_SORT_TYPE_LATEST_REPLY:
                $list = Post::query()->select($this->listRows)
                    ->where('audit_status', Constants::STATUS_DONE)
                    ->orderByDesc('sort_index')
                    ->orderByDesc($order)
                    ->offset($pageIndex * $pageSize)
                    ->limit($pageSize)
                    ->get();
                break;
            case Constants::POST_SORT_TYPE_REPLY_COUNT:
                $list = Post::query()->select($this->listRows)
                    ->where('audit_status', Constants::STATUS_DONE)
                    ->orderByDesc('sort_index')
                    ->orderByDesc($order)
                    ->orderByDesc('is_recommend')
                    ->orderByDesc('is_hot')
                    ->latest()
                    ->offset($pageIndex * $pageSize)
                    ->limit($pageSize)
                    ->get();
                break;
        }

        //增加是否阅读的状态
        $postIds = $list->pluck('post_id');
        $userReadList = [];
        if (Auth::isGuest() == false) {
            $userReadList = UserRead::query()->whereIn('post_id', $postIds)
                ->where('user_id', $this->userId())
                ->get()
                ->keyBy('post_id');
        }

        $list->map(function (Post $post) use ($userReadList) {
            if (!empty($post->avatar_list)) {
                $post->avatar_list = explode(';', $post->avatar_list);
            }
            if (!empty($post->image_list)) {
                $post->image_list = explode(';', $post->image_list);
            }
            $post->is_read = isset($userReadList[$post->post_id]) ? 1 : 0;
            return $post;
        });
        $total = Post::query()->where('audit_status', Constants::STATUS_DONE)->count();
        return ['total' => $total, 'list' => $list];
    }

    public function getUserPostList(int $pageIndex, int $pageSize, int $userId = null)
    {
        $isOther = isset($userId);
        if (!isset($userId)) {
            $userId = $this->userId();
        }
        $list = Post::query()->select($this->listRows)
            ->where(function (Builder $query) use ($isOther) {
                if ($isOther) {
                    $query->where('audit_status', Constants::STATUS_DONE);
                }
            })
            ->where('owner_id', $userId)
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->orderByDesc('sort_index')
            ->orderByDesc('is_hot')
            ->orderByDesc('is_recommend')
            ->latest()
            ->get();
        $list->map(function (Post $post) {
            if (!empty($post->avatar_list)) {
                $post->avatar_list = explode(';', $post->avatar_list);
            }
            if (!empty($post->image_list)) {
                $post->image_list = explode(';', $post->image_list);
            }
            return $post;
        });
        $total = Post::query()->where('owner_id', $userId)
            ->count();
        return ['total' => $total, 'list' => $list];
    }

    public function increaseRead(int $postId)
    {
        Post::query()->where('post_id', $postId)
            ->increment('read_count');
        return $this->success();
    }

    public function markRead(int $postId)
    {
        $userRead = UserRead::query()->where('user_id', $this->userId())
            ->where('post_id', $postId)
            ->first();
        if ($userRead instanceof UserRead) {
            throw new HyperfCommonException(ErrorCode::DO_NOT_REPEAT_ACTION);
        }
        $userRead = new UserRead();
        $userRead->user_id = $this->userId();
        $userRead->post_id = $postId;
        $userRead->saveOrFail();
        return $this->success();
    }

    public function favorite(int $postId)
    {
        $userFavorite = UserFavorite::query()->where('user_id', $this->userId())
            ->where('post_id', $postId)
            ->first();
        if ($userFavorite instanceof UserFavorite) {
            //取消收藏
            $userFavorite->delete();
            return $this->success();
        }
        $userFavorite = new UserFavorite();
        $userFavorite->post_id = $postId;
        $userFavorite->user_id = $this->userId();
        $userFavorite->saveOrFail();

        //刷新帖子信息
        $this->queueService->updatePost($postId);

        return $this->success();
    }

    public function reportPost(int $postId, string $content)
    {
        $report = new ReportPost();
        $report->post_id = $postId;
        $report->content = $content;
        $report->owner_id = $this->userId();
        $report->saveOrFail();
        return $this->success();
    }

    public function getUserFavoriteList(int $pageIndex, int $pageSize, int $userId = null)
    {
        if (!isset($userId)) {
            $userId = $this->userId();
        }
        $list = UserFavorite::query()
            ->join('post', 'user_favorite.post_id', '=', 'post.post_id')
            ->where('user_id', $userId)
            ->where('post.audit_status', Constants::STATUS_DONE)
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->orderByDesc('user_favorite.created_at')
            ->get()
            ->pluck('post');
        $list->map(function (Post $post) {
            if (!empty($post->avatar_list)) {
                $post->avatar_list = explode(';', $post->avatar_list);
            }
            if (!empty($post->image_list)) {
                $post->image_list = explode(';', $post->image_list);
            }
            return $post;
        });
        $total = UserFavorite::query()->where('user_id', $userId)
            ->join('post', 'user_favorite.post_id', '=', 'post.post_id')
            ->where('post.audit_status', Constants::STATUS_DONE)
            ->count();
        return ['total' => $total, 'list' => $list];
    }

    public function increaseForward(int $postId)
    {
        Post::findOrFail($postId)->increment('forward_count');
        return $this->success();
    }
}