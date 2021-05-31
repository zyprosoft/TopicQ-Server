<?php


namespace App\Service;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Job\AddScoreJob;
use App\Job\PostIncreaseReadJob;
use App\Job\PostMachineAuditJob;
use App\Model\Forum;
use App\Model\Post;
use App\Model\PostDocument;
use App\Model\ReportPost;
use App\Model\User;
use App\Model\UserFavorite;
use App\Model\UserRead;
use App\Model\UserSubscribe;
use App\Model\UserSubscribePassword;
use App\Model\UserVote;
use App\Model\Vote;
use App\Model\VoteItem;
use App\Model\Voucher;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;
use Hyperf\Utils\Str;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Facade\Auth;
use ZYProSoft\Log\Log;
use Hyperf\Di\Annotation\Inject;

class PostService extends BaseService
{
    /**
     * @Inject
     * @var VoucherService
     */
    protected VoucherService $voucherService;

    protected array $iconMap = [
        'word' => 'https://cdn.icodefuture.com/word.png',
        'pdf' => 'https://cdn.icodefuture.com/pdf.png',
        'excel' => 'https://cdn.icodefuture.com/excel.png'
    ];

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
        'avatar_list',
        'recommend_weight',
        'topic_id',
        'only_self_visible'
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
        //检查用户是不是被拉黑
        UserService::checkUserStatusOrFail();

        //检查普通用户是否有在这个版块发帖的权限
        if (isset($params['forumId']) && $params['forumId'] > 0 && $this->user()->role_id == 0) {
            $forum = Forum::findOrFail($params['forumId']);
            $user = $this->user();
            if(!empty($forum->can_post_user_group)) {
                $groupList = collect(explode(';',$forum->can_post_user_group));
                if (! $groupList->contains($user->group_id)) {
                    throw new HyperfCommonException(ErrorCode::USER_HAVE_NO_PERMISSION_POST_ON_THIS_FORUM);
                }
            }
        }

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
            $forumId = data_get($params,'forumId');
            $topicId = data_get($params,'topicId');
            $documents = data_get($params,'documents');

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
            if(isset($forumId)) {
                $post->forum_id = $forumId;
            }else{
                $post->forum_id = Constants::FORUM_MAIN_FORUM_ID;
            }
            if (isset($topicId)) {
                $post->topic_id = $topicId;
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
                if(Str::endsWith($link,'.mp4')) {
                    $post->has_video = 1;
                }
                $user = $this->user();
                if($user instanceof User && $user->isAdmin()) {
                    $post->is_video_admin = 1;
                }
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

            if (isset($documents)) {
                collect($documents)->map(function (array $item){
                   $document = new PostDocument();
                   $document->title = $item['title'];
                   $document->link = $item['link'];
                   $document->type = $item['type'];
                   $document->icon = $this->iconMap[$document->type];
                   $urlEncode = urlencode($document->link);
                   $document->jump_path = "pages/detail/detail?url=".$urlEncode;
                   $document->saveOrFail();
                });
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

        //异步订阅板块
        $this->queueService->subscribeForum($post->forum_id,$post->owner_id);

        //异步增加积分
        $scoreDesc = "发表帖子《{$post->title}》";
        $this->push(new AddScoreJob($post->owner_id,Constants::SCORE_ACTION_PUBLISH_POST, $scoreDesc));

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
        //检查用户是不是被拉黑
        UserService::checkUserStatusOrFail();

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
        if(isset($params['forumId'])) {
            $post->forum_id = $params['forumId'];
        }
        if (isset($params['topicId'])) {
            $post->topic_id = $params['topicId'];
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
            if(Str::endsWith($post->link,'.mp4')) {
                $post->has_video = 1;
            }
            $user = $this->user();
            if($user instanceof User && $user->isAdmin()) {
                $post->is_video_admin = 1;
            }
        }
        if (isset($params['content'])) {
            $post->content = $params['content'];
        }
        if (isset($params['documents'])) {
            //先全部删掉
            PostDocument::query()->where('post_id',$post->post_id)->delete();
            collect($params['documents'])->map(function (array $item){
                $document = new PostDocument();
                $document->title = $item['title'];
                $document->link = $item['link'];
                $document->type = $item['type'];
                $document->icon = $this->iconMap[$document->type];
                $urlEncode = urlencode($document->link);
                $document->jump_path = "pages/detail/detail?url=".$urlEncode;
                $document->saveOrFail();
            });
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
            ->with(['vote','mini_program','official_account','forum','forum_voucher','voucher_policy','document_list'])
            ->first();
        if (!$post instanceof Post) {
            throw new HyperfCommonException(ErrorCode::POST_NOT_EXIST);
        }
        //用不到avatar_list
        $post->avatar_list = null;
        
        if(!empty($post->image_list)) {
            $post->image_list = explode(';', $post->image_list);
        }
        //解码购物信息
        if (isset($post->mall_goods)) {
            $post->mall_goods = json_decode($post->mall_goods);
        }
        if (isset($post->mall_goods_buy_info)) {
            $post->mall_goods_buy_info = json_decode($post->mall_goods_buy_info);
        }
        if (Auth::isGuest() == false) {
            //从逻辑层面杜绝订阅或者授权板块的帖子被查看
            $forum = Forum::findOrFail($post->forum_id);
            $user = $this->user();
            $isAdmin = false;
            if ($user instanceof User) {
                $isAdmin = $user->isAdmin();
            }
            //需要检查订阅权限，并且不是管理员
            if($forum->needCheckSubscribe() && $isAdmin == false) {
                $userSubscribe = UserSubscribe::query()->where('user_id',$this->userId())
                                                               ->where('forum_id',$post->forum_id)
                                                               ->first();
                if (!$userSubscribe instanceof UserSubscribe) {
                    //未支付，但是需要返回部分信息供后续购买或授权做引导作用
                    $limitPost = Post::query()->select(['title','forum_id'])
                                        ->where('post_id', $postId)
                                        ->with(['forum'])
                                        ->firstOrFail();
                    if($forum->goods_id > 0) {
                        return $this->errorWithData(ErrorCode::FORUM_POST_NEED_PAY,'该帖子属于付费板块',$limitPost);
                    }elseif ($forum->need_auth) {
                        return $this->errorWithData(ErrorCode::FORUM_POST_NEED_AUTH,'该帖子属于授权板块',$limitPost);
                    }
                }
            }
            //版块是否有分组访问权限,普通用户之上无限制
            if(!empty($forum->can_access_user_group) && $user->role_id < Constants::USER_ROLE_ADMIN) {
                //用户是不是有这个版块的发帖权限
                $canAccess = false;
                if (!empty($forum->can_post_user_group)) {
                    $groupList = collect(explode(';',$forum->can_post_user_group));
                    if ($groupList->contains($user->group_id)) {
                        $canAccess = true;
                    }
                }
                if ($canAccess == false) {
                    $groupList = collect(explode(';',$forum->can_access_user_group));
                    if ($groupList->contains($user->group_id)) {
                        $canAccess = true;
                    }
                }
                if($canAccess == false) {
                    throw new HyperfCommonException(ErrorCode::FORUM_POST_NEED_AUTH);
                }
            }
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
            //如果有订阅券，查看是不是已经领取过
            if($post->policy_id > 0) {
                $userSubscribeVoucher = UserSubscribePassword::query()->where('owner_id',$this->userId())
                                                                    ->where('policy_id',$post->policy_id)
                                                                    ->first();
                if ($userSubscribeVoucher instanceof UserSubscribePassword) {
                    $post->finish_get_policy = 1;
                }else{
                    $post->finish_get_policy = 0;
                }
            }
            if($post->voucher_policy_id > 0) {
                //如果有代金券，查看是不是已经领取过
                $voucher = Voucher::query()->where('owner_id',$this->userId())
                    ->where('policy_id',$post->voucher_policy_id)
                    ->first();
                if ($voucher instanceof Voucher) {
                    $post->finish_get_voucher = 1;
                }else{
                    $post->finish_get_voucher = 0;
                }
            }
        } else {
            //需要检查订阅权限，并且不是管理员
            $forum = Forum::findOrFail($post->forum_id);
            if($forum->needCheckSubscribe()) {
                //没有登陆，必然没有权限
                if($forum->goods_id > 0) {
                    throw new HyperfCommonException(ErrorCode::FORUM_POST_NEED_PAY);
                }elseif ($forum->need_auth) {
                    throw new HyperfCommonException(ErrorCode::FORUM_POST_NEED_AUTH);
                }
            }
            $post->is_read = 0;
            $post->is_voted = 0;
            $post->is_favorite = 0;
            $post->finish_get_policy = 0;
            $post->finish_get_voucher = 0;
        }

        //解析代金券信息
        if(isset($post->voucher_policy)) {
            $this->voucherService->decodeVoucherInfo($post->voucher_policy);
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
        //返回订阅内容
        if($sortType == Constants::POST_SORT_TYPE_SUBSCRIBE) {
            return $this->getPostListBySubscribe($pageIndex, $pageSize);
        }
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
                    ->where('forum_id',Constants::FORUM_MAIN_FORUM_ID)
                    ->where('only_self_visible',Constants::STATUS_NOT)
                    ->orderByDesc('sort_index')
                    ->orderByDesc($order)
                    ->offset($pageIndex * $pageSize)
                    ->limit($pageSize)
                    ->get();
                break;
            case Constants::POST_SORT_TYPE_REPLY_COUNT:
                $list = Post::query()->select($this->listRows)
                    ->where('audit_status', Constants::STATUS_DONE)
                    ->where('forum_id',Constants::FORUM_MAIN_FORUM_ID)
                    ->where('only_self_visible',Constants::STATUS_NOT)
                    ->orderByDesc('sort_index')
                    ->orderByDesc('recommend_weight')
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
            }else{
                $post->avatar_list = null;
            }
            if (!empty($post->image_list)) {
                $post->image_list = explode(';', $post->image_list);
            }
            $post->is_read = isset($userReadList[$post->post_id]) ? 1 : 0;
            return $post;
        });
        $total = Post::query()
                ->where('audit_status', Constants::STATUS_DONE)
                ->where('only_self_visible',Constants::STATUS_NOT)
                ->count();
        return ['total' => $total, 'list' => $list];
    }

    public function getUserPostList(int $pageIndex, int $pageSize, int $userId = null)
    {
        $isOther = isset($userId);
        if (!isset($userId)) {
            $userId = $this->userId();
        }
        $list = Post::query()->select($this->listRows)
            ->when($isOther,function (Builder $query) {
                $query->where('audit_status', Constants::STATUS_DONE);
                $query->where('only_self_visible',Constants::STATUS_NOT);
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
            }else{
                $post->avatar_list = null;
            }
            if (!empty($post->image_list)) {
                $post->image_list = explode(';', $post->image_list);
            }
            return $post;
        });
        $total = Post::query()->where('owner_id', $userId)
            ->when($isOther,function (Builder $query) {
                $query->where('audit_status', Constants::STATUS_DONE);
                $query->where('only_self_visible',Constants::STATUS_NOT);
            })
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
        //检查用户是不是被拉黑
        UserService::checkUserStatusOrFail();

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

        //异步增加积分
        $post = Post::find($postId);
        $scoreDesc = "收藏帖子《{$post->title}》";
        $this->push(new AddScoreJob($post->owner_id,Constants::SCORE_ACTION_POST_FAVORITE, $scoreDesc));

        return $this->success();
    }

    public function reportPost(int $postId, string $content)
    {
        //检查用户是不是被拉黑
        UserService::checkUserStatusOrFail();

        $report = new ReportPost();
        $report->post_id = $postId;
        $report->content = $content;
        $report->owner_id = $this->userId();
        $report->saveOrFail();
        return $this->success();
    }

    public function getUserFavoriteList(int $pageIndex, int $pageSize, int $userId = null)
    {
        $hiddenNotVisible = true;
        if (!isset($userId)) {
            $userId = $this->userId();
            $hiddenNotVisible = false;
        }
        $list = UserFavorite::query()
            ->join('post', 'user_favorite.post_id', '=', 'post.post_id')
            ->where('user_id', $userId)
            ->where('post.audit_status', Constants::STATUS_DONE)
            ->when($hiddenNotVisible,function (Builder $query) {
                $query->where('post.only_self_visible',Constants::STATUS_NOT);
            })
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->orderByDesc('user_favorite.created_at')
            ->get()
            ->pluck('post');
        $list->map(function (Post $post) {
            if (!empty($post->avatar_list)) {
                $post->avatar_list = explode(';', $post->avatar_list);
            }else{
                $post->avatar_list = null;
            }
            if (!empty($post->image_list)) {
                $post->image_list = explode(';', $post->image_list);
            }
            return $post;
        });
        $total = UserFavorite::query()->where('user_id', $userId)
            ->join('post', 'user_favorite.post_id', '=', 'post.post_id')
            ->where('post.audit_status', Constants::STATUS_DONE)
            ->when($hiddenNotVisible,function (Builder $query){
                $query->where('post.only_self_visible',Constants::STATUS_NOT);
            })
            ->count();
        return ['total' => $total, 'list' => $list];
    }

    public function increaseForward(int $postId)
    {
        Post::findOrFail($postId)->increment('forward_count');
        return $this->success();
    }

    public function successForward(int $postId)
    {
        if (Auth::isGuest() == true) {
            return $this->success();
        }
        //异步增加积分
        $post = Post::find($postId);
        $scoreDesc = "分享帖子《{$post->title}》";
        $this->push(new AddScoreJob($post->owner_id,Constants::SCORE_ACTION_SHARE, $scoreDesc));
        return $this->success();
    }

    public function praise(int $postId)
    {
        Post::findOrFail($postId)->increment('praise_count');

        //异步增加积分
        $post = Post::find($postId);
        $scoreDesc = "点赞帖子《{$post->title}》";
        $this->push(new AddScoreJob($post->owner_id,Constants::SCORE_ACTION_POST_PRAISE, $scoreDesc));

        return $this->success();
    }

    public function getPostListBySubscribeByForumId(int $pageIndex, int $pageSize, int $forumId)
    {
        //用户是不是已经订阅了此板块,或者是管理员以上身份
        $user = User::findOrFail($this->userId());
        //非管理员身份需要校验订阅权限
        if ($user->role_id < Constants::USER_ROLE_ADMIN) {
            $forum = Forum::findOrFail($forumId);
            //授权或者订阅类板块
            if($forum->need_auth == 1 || $forum->goods_id > 0) {
                $userSubscribe = UserSubscribe::query()->where('user_id',$user->user_id)
                    ->where('forum_id',$forumId)
                    ->first();
                if (!$userSubscribe instanceof UserSubscribe) {
                    throw new HyperfCommonException(ErrorCode::FORUM_NOT_PAY_OR_AUTH);
                }
            }else{
                //是不是有发帖权限，有的话就可以看
                $canAccessForum = false;
                if(!empty($forum->can_post_user_group)) {
                    $postUserGroup = collect(explode(';',$forum->can_post_user_group));
                    if($postUserGroup->contains($user->group_id)){
                        $canAccessForum = true;
                    }
                }
                //如果没有发帖权限，看下是不是有访问权限
                if ($canAccessForum == false) {
                    if (!empty($forum->can_access_user_group)) {
                        $accessUserGroup = collect(explode(';',$forum->can_access_user_group));
                        if($accessUserGroup->contains($user->group_id)) {
                            $canAccessForum = true;
                        }
                    }else{
                        //空的时候都有访问权限
                        $canAccessForum = true;
                        Log::info("版块({$forum->name})所有用户均可访问!");
                    }
                }
                if($canAccessForum == false) {
                    throw new HyperfCommonException(ErrorCode::FORUM_NOT_PAY_OR_AUTH,"当前所在用户组无权访问此版块");
                }
            }
        }

        $selectRows = [
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
            'avatar_list',
            'recommend_weight',
            'topic_id',
            'only_self_visible'
        ];

        $list = Post::query()->select($selectRows)
            ->with(['forum'])
            ->where('forum_id',$forumId)
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('only_self_visible', Constants::STATUS_NOT)
            ->orderByDesc('sort_index')
            ->orderByDesc('recommend_weight')
            ->latest()
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();

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
            }else{
                $post->avatar_list = null;
            }
            if (!empty($post->image_list)) {
                $post->image_list = explode(';', $post->image_list);
            }
            $post->is_read = isset($userReadList[$post->post_id]) ? 1 : 0;
            return $post;
        });

        $total = Post::query()->select($selectRows)
            ->where('forum_id',$forumId)
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('only_self_visible', Constants::STATUS_NOT)
            ->count();

        return ['total'=>$total, 'list'=>$list];
    }

    public function getPostListBySubscribe(int $pageIndex, int $pageSize)
    {
        $selectRows = [
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
            'post.created_at',
            'post.updated_at',
            'join_user_count',
            'avatar_list',
            'user_subscribe.forum_id',
            'user_id',
            'recommend_weight',
            'topic_id',
            'only_self_visible'
        ];

        $list = Post::query()->select($selectRows)
            ->with(['forum'])
            ->leftJoin('user_subscribe','post.forum_id','=','user_subscribe.forum_id')
            ->where('user_subscribe.forum_id','>',Constants::FORUM_MAIN_FORUM_ID)
            ->where('user_id',$this->userId())
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('only_self_visible', Constants::STATUS_NOT)
            ->orderByDesc('sort_index')
            ->orderByDesc('recommend_weight')
            ->latest()
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();

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
            }else{
                $post->avatar_list = null;
            }
            if (!empty($post->image_list)) {
                $post->image_list = explode(';', $post->image_list);
            }
            $post->is_read = isset($userReadList[$post->post_id]) ? 1 : 0;
            return $post;
        });

        $total = Post::query()->select($selectRows)
            ->leftJoin('user_subscribe','post.forum_id','=','user_subscribe.forum_id')
            ->where('user_id',$this->userId())
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('user_subscribe.forum_id','>',Constants::FORUM_MAIN_FORUM_ID)
            ->where('only_self_visible', Constants::STATUS_NOT)
            ->count();

        return ['total'=>$total, 'list'=>$list];
    }

    public function getVideoPostList(int $pageIndex, int $pageSize, int $type = Constants::VIDEO_POST_LIST_TYPE_ADMIN)
    {
        $list = Post::query()->where('has_video',Constants::STATUS_OK)
                             ->where(function (Builder $query) use ($type){
                                 if ($type == Constants::VIDEO_POST_LIST_TYPE_ADMIN) {
                                     $query->where('is_video_admin',Constants::STATUS_OK);
                                 }elseif ($type == Constants::VIDEO_POST_LIST_TYPE_CUSTOMER) {
                                     $query->where('is_video_admin','<>', Constants::STATUS_OK);
                                 }
                             })
                             ->where('only_self_visible', Constants::STATUS_NOT)
                             ->orderByDesc('recommend_weight')
                             ->offset($pageIndex * $pageSize)
                             ->limit($pageSize)
                             ->get();
        //检查用户收藏状态
        if(Auth::isGuest() == false) {
            $postIds = $list->pluck('post_id');
            $favoriteList = UserFavorite::query()->where('user_id',$this->userId())
                ->whereIn('post_id',$postIds)
                ->get()
                ->keyBy('post_id');
            $list->map(function (Post $post) use ($favoriteList) {
                if (!empty($favoriteList->get($post->post_id))) {
                    $post->is_favorite = 1;
                }else{
                    $post->is_favorite = 0;
                }
                return $post;
            });
        }else{
            $list->map(function (Post $post) {
               $post->is_favorite = 0;
               return $post;
            });
        }

        $total = Post::query()->where('has_video',Constants::STATUS_OK)
            ->where('only_self_visible', Constants::STATUS_NOT)
            ->where(function (Builder $query) use ($type){
                if ($type == Constants::VIDEO_POST_LIST_TYPE_ADMIN) {
                    $query->where('is_video_admin',Constants::STATUS_OK);
                }elseif ($type == Constants::VIDEO_POST_LIST_TYPE_CUSTOMER) {
                    $query->where('is_video_admin','<>', Constants::STATUS_OK);
                }
            })->count();
        return ['total'=>$total,'list'=>$list];
    }

    public function getPostListByTopicId(int $pageIndex, int $pageSize, int $topicId, int $type = Constants::TOPIC_POST_LIST_SORT_BY_HOT)
    {
        $selectRows = [
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
            'avatar_list',
            'recommend_weight',
            'topic_id',
            'only_self_visible'
        ];

        if($type == Constants::TOPIC_POST_LIST_SORT_BY_LATEST) {
            $list = Post::query()->select($selectRows)
                ->with(['forum'])
                ->where('topic_id',$topicId)
                ->where('audit_status', Constants::STATUS_DONE)
                ->where('only_self_visible', Constants::STATUS_NOT)
                ->latest()
                ->offset($pageIndex * $pageSize)
                ->limit($pageSize)
                ->get();
        }else{
            $list = Post::query()->select($selectRows)
                ->with(['forum'])
                ->where('topic_id',$topicId)
                ->where('audit_status', Constants::STATUS_DONE)
                ->where('only_self_visible', Constants::STATUS_NOT)
                ->orderByDesc('sort_index')
                ->orderByDesc('recommend_weight')
                ->orderByDesc('comment_count')
                ->orderByDesc('praise_count')
                ->orderByDesc('read_count')
                ->latest()
                ->offset($pageIndex * $pageSize)
                ->limit($pageSize)
                ->get();
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
            }else{
                $post->avatar_list = null;
            }
            if (!empty($post->image_list)) {
                $post->image_list = explode(';', $post->image_list);
            }
            $post->is_read = isset($userReadList[$post->post_id]) ? 1 : 0;
            return $post;
        });

        $total = Post::query()->select($selectRows)
            ->where('topic_id',$topicId)
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('only_self_visible', Constants::STATUS_NOT)
            ->count();

        return ['total'=>$total, 'list'=>$list];
    }

    public function updateOnlySelfVisible(int $postId, int $status)
    {
        $this->checkOwnOrFail($postId);
        $post = Post::findOrFail($postId);
        if($post->only_self_visible == $status) {
            return $this->success();
        }
        $post->only_self_visible = $status;
        $post->saveOrFail();
        return $this->success();
    }
}