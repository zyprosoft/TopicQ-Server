<?php


namespace App\Service;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Job\AddScoreJob;
use App\Job\PostIncreaseReadJob;
use App\Job\PostMachineAuditJob;
use App\Model\Circle;
use App\Model\CircleTopic;
use App\Model\Comment;
use App\Model\Forum;
use App\Model\Post;
use App\Model\PostDocument;
use App\Model\ReportPost;
use App\Model\User;
use App\Model\UserAttentionOther;
use App\Model\UserAttentionTopic;
use App\Model\UserFavorite;
use App\Model\UserPraisePost;
use App\Model\UserRead;
use App\Model\UserSubscribe;
use App\Model\UserSubscribePassword;
use App\Model\UserVote;
use App\Model\Vote;
use App\Model\VoteItem;
use App\Model\Voucher;
use Carbon\Carbon;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;
use Hyperf\Utils\Collection;
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
        'only_self_visible',
        'image_ids',
        'has_video',
        'post.forum_id',
        'circle_id'
    ];

    private array $activeListRows = [
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
        'only_self_visible',
        'rich_content',
        'image_ids',
        'has_video',
        'circle_topic_id',
        'favorite_count',
        'praise_count',
        'circle_id'
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
        if ($user->role_id <= Constants::USER_ROLE_SUB_ADMIN) {
            //检查是不是在使用化身
            if ($user->avatar_user_id > 0) {
                Log::info("使用化身($user->avatar_user_id)");
                return $user->avatar_user_id;
            }
        }
        return $userId;
    }

    protected function trimString(string $content = null)
    {
        if(empty($content)) {
            return $content;
        }
        $chars = [" ","　","\t","\n","\r"];
        return str_replace($chars,"",$content);
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
            if (isset($params['title'])) {
                $title = $params['title'];
            }else{
                $title = '';
            }
            $content = data_get($params, 'content');
            $link = data_get($params, 'link');
            $imageList = data_get($params, 'imageList');
            $vote = data_get($params, 'vote');
            $programId = data_get($params,'programId');
            $accountId = data_get($params,'accountId');
            $forumId = data_get($params,'forumId');
            $topicId = data_get($params,'topicId');
            $documents = data_get($params,'documents');
            $richContent = data_get($params,'richContent');
            $circleId = data_get($params,'circleId');
            $circleTopicId = data_get($params,'circleTopicId');
            $circleTopic = data_get($params,'circleTopic');

            $post = new Post();
            $post->owner_id = $this->userId();
            $post->title = $title;
            if (mb_strlen($content) < 40) {
                $post->summary = $this->trimString($content);
            } else {
                $post->summary = $this->trimString(mb_substr($content, 0, 40));
            }
            if(isset($content)) {
                $post->content = $content;
            }
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

            if(isset($richContent)) {
                //处理一些没用的字段
                $imageIds = [];
                $imageList = [];
                $summary = '';
                $hasVideo = 0;
                $filterRichContent = collect($params['richContent'])->map(function (array $item) use (&$imageIds,&$imageList,&$summary,&$hasVideo){
                    if($item['type'] == Constants::RICH_CONTENT_TYPE_TEXT && mb_strlen($summary) < 40) {
                        $summary .= $item['content'];
                        if (mb_strlen($summary) > 40) {
                            $summary = mb_substr($summary,0,40);
                            $summary = $this->trimString($summary);
                        }
                    }
                    if($item['type'] == Constants::RICH_CONTENT_TYPE_BIG_IMAGE) {
                        $item['image']['local'] = $item['image']['remote'];
                        $item['image']['is_uping'] = 0;
                        $imageIds[] = $item['image']['fileKey'];
                        $imageList[] = $item['image']['remote'];
                    }
                    if($item['type'] == Constants::RICH_CONTENT_TYPE_SMALL_IMAGE) {
                        foreach ($item['image_list'] as $index => $imgItem) {
                            $item['image_list'][$index]['local'] = $item['image_list'][$index]['remote'];
                            $item['image_list'][$index]['is_uping'] = 0;
                            $imageIds[] = $imgItem['fileKey'];
                            $imageList[] = $imgItem['remote'];
                        }
                    }
                    if($item['type'] == Constants::RICH_CONTENT_TYPE_VIDEO) {
                        unset($item['local']);
                        $hasVideo = 1;
                    }
                    return $item;
                });
                $post->has_video = $hasVideo;
                $post->summary = $summary;
                //json编码后存储
                $post->rich_content = json_encode($filterRichContent);
                //检测图片是否通过审核
                $post->image_ids = implode(';',$imageIds);
                //检测上传图片
                $imageAuditCheck = $this->auditImageOrFail($imageList,true);
            }
            //圈子
            if (isset($circleId)) {
                $post->circle_id = $circleId;
                //圈话题
                if(isset($circleTopicId)) {
                    $post->circle_topic_id = $circleTopicId;
                }elseif (isset($circleTopic)) {
                    $existCircleTopic = CircleTopic::query()->where('title',$circleTopic)
                        ->where('circle_id',$circleId)
                        ->first();
                    if ($existCircleTopic instanceof CircleTopic) {
                        $post->circle_topic_id = $existCircleTopic->topic_id;
                    }else {
                        $existCircleTopic = new CircleTopic();
                        $existCircleTopic->title = $circleTopic;
                        $existCircleTopic->circle_id = $circleId;
                        $existCircleTopic->owner_id = $this->userId();
                        $existCircleTopic->saveOrFail();
                        $post->circle_topic_id = $existCircleTopic->topic_id;
                    }
                }
            }

            //审核结果
            Log::info("图片审核结果:".json_encode($imageAuditCheck));
            if($imageAuditCheck['need_review']) {
                $post->machine_audit = Constants::STATUS_REVIEW;
            }
            //活跃时间
            $post->last_active_time = Carbon::now()->toDateTimeString();
            $post->saveOrFail();

            //成员圈内活跃时间更新
            if(isset($circleId)) {
                $this->queueService->refreshUserCircleInfo($this->userId(),$circleId);
            }

            if (isset($documents)) {
                collect($documents)->map(function (array $item) use ($post){
                    $document = new PostDocument();
                    $document->title = $item['title'];
                    $document->link = $item['link'];
                    $document->type = $item['type'];
                    $document->icon = $this->iconMap[$document->type];
                    $document->post_id = $post->post_id;
                   $document->saveOrFail();
                });
            }

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
        if (isset($params['circleId'])) {
            $post->circle_id = $params['circleId'];
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
            collect($params['documents'])->map(function (array $item) use ($post) {
                $document = new PostDocument();
                $document->title = $item['title'];
                $document->link = $item['link'];
                $document->type = $item['type'];
                $document->icon = $this->iconMap[$document->type];
                $document->post_id = $post->post_id;
                $document->saveOrFail();
            });
        }

        if(isset($params['richContent'])) {
            //处理一些没用的字段
            $imageIds = [];
            $imageList = [];
            $summary = '';
            $hasVideo = 0;
            $filterRichContent = collect($params['richContent'])->map(function (array $item) use (&$imageIds,&$imageList,&$summary,&$hasVideo){
                if($item['type'] == Constants::RICH_CONTENT_TYPE_TEXT && mb_strlen($summary) < 40) {
                    $summary .= $item['content'];
                    if (mb_strlen($summary) > 40) {
                        $summary = mb_substr($summary,0,40);
                    }
                }
                if($item['type'] == Constants::RICH_CONTENT_TYPE_BIG_IMAGE) {
                    $item['image']['local'] = $item['image']['remote'];
                    $item['image']['is_uping'] = 0;
                    $imageIds[] = $item['image']['fileKey'];
                    $imageList[] = $item['image']['remote'];
                }
                if($item['type'] == Constants::RICH_CONTENT_TYPE_SMALL_IMAGE) {
                    foreach ($item['image_list'] as $index => $imgItem) {
                        $item['image_list'][$index]['local'] = $item['image_list'][$index]['remote'];
                        $item['image_list'][$index]['is_uping'] = 0;
                        $imageIds[] = $imgItem['fileKey'];
                        $imageList[] = $imgItem['remote'];
                    }
                }
                if($item['type'] == Constants::RICH_CONTENT_TYPE_VIDEO) {
                    unset($item['local']);
                    $hasVideo = 1;
                }
                return $item;
            });
            $post->has_video = $hasVideo;
            $post->summary = $summary;
            //json编码后存储
            $post->rich_content = json_encode($filterRichContent);
            //检测图片是否通过审核
            $post->image_ids = implode(';',$imageIds);
            //检测上传图片
            $imageAuditCheck = $this->auditImageOrFail($imageList,true);
        }
        $post->audit_status = 0;//恢复待审核
        //审核结果
        Log::info("图片审核结果:".json_encode($imageAuditCheck));
        if($imageAuditCheck['need_review']) {
            $post->machine_audit = Constants::STATUS_REVIEW;
        }
        //活跃时间
        $post->last_active_time = Carbon::now()->toDateTimeString();
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
            //对作者的关注状态
            if($this->userId() !== $post->owner_id) {
                $attention = UserAttentionOther::query()->where('user_id',$this->userId())
                    ->where('other_user_id',$post->owner_id)
                    ->first();
                if($attention instanceof UserAttentionOther) {
                    $post->author_attention = 1;
                }else{
                    $post->author_attention = 0;
                }
            }else{
                $post->author_attention = 0;
            }
            //是否点赞
            $praise = UserPraisePost::query()->where('user_id',$this->userId())
                                             ->where('post_id',$postId)
                                             ->first();
            if($praise instanceof UserPraisePost) {
                $post->is_praise = 1;
            }else{
                $post->is_praise = 0;
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
            $post->is_praise = 0;
            $post->is_read = 0;
            $post->is_voted = 0;
            $post->is_favorite = 0;
            $post->finish_get_policy = 0;
            $post->finish_get_voucher = 0;
            $post->author_attention = 0;
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

    public function postListAddReadStatus(Collection &$list, bool $needReadStatus=true)
    {
        //增加是否阅读的状态
        $postIds = $list->pluck('post_id');
        $userReadList = [];
        if($needReadStatus) {
            $userReadList = [];
            if (Auth::isGuest() == false) {
                $userReadList = UserRead::query()->whereIn('post_id', $postIds)
                    ->where('user_id', $this->userId())
                    ->get()
                    ->keyBy('post_id');
            }
        }

        $list->map(function (Post $post) use ($userReadList) {
            if (!empty($post->avatar_list)) {
                $post->avatar_list = explode(';', $post->avatar_list);
            }else{
                $post->avatar_list = null;
            }
            if (!empty($post->image_list)) {
                $post->image_list = explode(';', $post->image_list);
            }else{
                if (!empty($post->image_ids)) {
                    //如果是富文本编辑
                    $imageList = collect();
                    $cdnDomain = config('qiniu.cdnDomain');
                    $post->image_ids = explode(';',$post->image_ids);
                    collect($post->image_ids)->map(function (string $imageId) use(&$imageList,$cdnDomain){
                        $imageUrl = $cdnDomain.$imageId;
                        //只返回三张
                        if($imageList->count()<3) {
                            $imageList->push($imageUrl);
                        }
                    });
                    $post->image_list = $imageList;
                }
            }
            $post->is_read = isset($userReadList[$post->post_id]) ? 1 : 0;
            return $post;
        });
    }

    public function getList(int $sortType, int $pageIndex, int $pageSize)
    {
        //返回订阅内容
        if($sortType == Constants::POST_SORT_TYPE_SUBSCRIBE) {
            return $this->getPostListBySubscribe($pageIndex, $pageSize);
        }
        if($sortType == Constants::POST_SORT_TYPE_ATTENTION) {
            return  $this->getPostListByAttention($pageIndex, $pageSize);
        }
        $map = [
            Constants::POST_SORT_TYPE_LATEST => 'last_active_time',
            Constants::POST_SORT_TYPE_LATEST_REPLY => 'last_comment_time',
            Constants::POST_SORT_TYPE_REPLY_COUNT => 'comment_count'
        ];
        $order = $map[$sortType];
        switch ($sortType) {
            case Constants::POST_SORT_TYPE_LATEST:
            case Constants::POST_SORT_TYPE_LATEST_REPLY:
                $list = Post::query()->select($this->listRows)
                    ->with(['forum'])
                    ->where('audit_status', Constants::STATUS_DONE)
                    ->where('only_self_visible',Constants::STATUS_NOT)
                    ->where('circle_id', Constants::STATUS_NOT)
                    ->orderByDesc('sort_index')
                    ->orderByDesc($order)
                    ->offset($pageIndex * $pageSize)
                    ->limit($pageSize)
                    ->get();
                break;
            case Constants::POST_SORT_TYPE_REPLY_COUNT:
                $list = Post::query()->select($this->listRows)
                    ->with(['forum'])
                    ->where('audit_status', Constants::STATUS_DONE)
                    ->where('only_self_visible',Constants::STATUS_NOT)
                    ->where('circle_id', Constants::STATUS_NOT)
                    ->orderByDesc('sort_index')
                    ->orderByDesc('recommend_weight')
                    ->latest()
                    ->offset($pageIndex * $pageSize)
                    ->limit($pageSize)
                    ->get();
                break;
        }

        $this->postListAddReadStatus($list);

        $total = Post::query()
                ->where('audit_status', Constants::STATUS_DONE)
                ->where('only_self_visible',Constants::STATUS_NOT)
                ->where('circle_id',Constants::STATUS_NOT)
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
            ->with(['forum'])
            ->when($isOther,function (Builder $query) {
                $query->where('audit_status', Constants::STATUS_DONE);
                $query->where('only_self_visible',Constants::STATUS_NOT);
            })
            ->where('circle_id',Constants::STATUS_NOT)
            ->where('owner_id', $userId)
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->orderByDesc('sort_index')
            ->orderByDesc('is_hot')
            ->orderByDesc('is_recommend')
            ->latest()
            ->get();

        $this->postListAddReadStatus($list,false);

        $total = Post::query()->where('owner_id', $userId)
            ->when($isOther,function (Builder $query) {
                $query->where('audit_status', Constants::STATUS_DONE);
                $query->where('only_self_visible',Constants::STATUS_NOT);
            })
            ->where('circle_id',Constants::STATUS_NOT)
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
            ->where('circle_id',Constants::STATUS_NOT)
            ->when($hiddenNotVisible,function (Builder $query) {
                $query->where('post.only_self_visible',Constants::STATUS_NOT);
            })
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->orderByDesc('user_favorite.created_at')
            ->get()
            ->pluck('post');
        $this->postListAddReadStatus($list,false);
        $total = UserFavorite::query()->where('user_id', $userId)
            ->join('post', 'user_favorite.post_id', '=', 'post.post_id')
            ->where('post.audit_status', Constants::STATUS_DONE)
            ->where('circle_id',Constants::STATUS_NOT)
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
        $praise = UserPraisePost::query()->where('user_id',$this->userId())
                                         ->where('post_id', $postId)
                                         ->first();
        if ($praise instanceof UserPraisePost) {
            //取消
            $praise->delete();
            return $this->success();
        }
        $post = Post::find($postId);

        $praise = new UserPraisePost();
        $praise->post_owner_id = $post->owner_id;
        $praise->user_id = $this->userId();
        $praise->post_id = $postId;

        //自己给自己点赞不提醒
        if($post->owner_id == $this->userId()) {
            $praise->owner_read_status = Constants::STATUS_OK;
        }

        $praise->saveOrFail();

        //异步刷新帖子信息
        $this->queueService->updatePost($postId);

        //异步增加积分
        $scoreDesc = "点赞帖子《{$post->title}》";
        $this->push(new AddScoreJob($post->owner_id,Constants::SCORE_ACTION_POST_PRAISE, $scoreDesc));

        return $this->success();
    }

    public function getPostListBySubscribeByForumId(int $pageIndex, int $pageSize, int $forumId, int $type = null)
    {
        if (!isset($type)) {
            $type = Constants::FORUM_POST_SORT_HOT;
        }

        //用户是不是已经订阅了此板块,或者是管理员以上身份
        //分享出去的时候没有登录态,允许访问内容
        if(Auth::isGuest() == false) {
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
            'only_self_visible',
            'rich_content',
            'image_ids',
            'has_video',
            'post.forum_id'
        ];

        if($type == Constants::FORUM_POST_SORT_LATEST) {
            $list = Post::query()->select($selectRows)
                ->with(['forum'])
                ->where('forum_id',$forumId)
                ->where('audit_status', Constants::STATUS_DONE)
                ->where('only_self_visible', Constants::STATUS_NOT)
                ->where('circle_id',Constants::STATUS_NOT)
                ->orderByDesc('sort_index')
                ->orderByDesc('last_active_time')
                ->offset($pageIndex * $pageSize)
                ->limit($pageSize)
                ->get();
        }else{
            $list = Post::query()->select($selectRows)
                ->with(['forum'])
                ->where('forum_id',$forumId)
                ->where('audit_status', Constants::STATUS_DONE)
                ->where('only_self_visible', Constants::STATUS_NOT)
                ->where('circle_id',Constants::STATUS_NOT)
                ->orderByDesc('sort_index')
                ->orderByDesc('recommend_weight')
                ->orderByDesc('last_active_time')
                ->offset($pageIndex * $pageSize)
                ->limit($pageSize)
                ->get();
        }

        $this->postListAddReadStatus($list);

        $total = Post::query()->select($selectRows)
            ->where('forum_id',$forumId)
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('only_self_visible', Constants::STATUS_NOT)
            ->where('circle_id',Constants::STATUS_NOT)
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
            'only_self_visible',
            'rich_content',
            'image_ids',
            'has_video',
            'post.forum_id'
        ];

        $list = Post::query()->select($selectRows)
            ->with(['forum'])
            ->leftJoin('user_subscribe','post.forum_id','=','user_subscribe.forum_id')
            ->where('user_subscribe.forum_id','>',Constants::FORUM_MAIN_FORUM_ID)
            ->where('user_id',$this->userId())
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('only_self_visible', Constants::STATUS_NOT)
            ->where('circle_id', Constants::STATUS_NOT)
            ->orderByDesc('sort_index')
            ->orderByDesc('last_active_time')
            ->orderByDesc('recommend_weight')
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();

        $this->postListAddReadStatus($list);

        $total = Post::query()->select($selectRows)
            ->leftJoin('user_subscribe','post.forum_id','=','user_subscribe.forum_id')
            ->where('user_id',$this->userId())
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('user_subscribe.forum_id','>',Constants::FORUM_MAIN_FORUM_ID)
            ->where('only_self_visible', Constants::STATUS_NOT)
            ->where('circle_id',Constants::STATUS_NOT)
            ->count();

        return ['total'=>$total, 'list'=>$list];
    }

    public function getPostListByAttention(int $pageIndex, int $pageSize)
    {
        if(Auth::isGuest() == true) {
            return ['total'=>0,'list'=>[]];
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
            'only_self_visible',
            'rich_content',
            'image_ids',
            'has_video',
            'post.forum_id'
        ];

        //关注的话题ID
        $attentionTopicIds = UserAttentionTopic::query()->where('user_id',$this->userId())
            ->get()
            ->pluck('topic_id');
        $userIds = UserAttentionOther::query()->where('user_id',$this->userId())
            ->get()
            ->pluck('other_user_id');

        if($attentionTopicIds->isEmpty() && $userIds->isEmpty()) {
            return ['total'=>0,'list'=>[]];
        }

        $list = Post::query()->select($selectRows)
            ->with(['forum'])
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('only_self_visible', Constants::STATUS_NOT)
            ->when($attentionTopicIds->isNotEmpty(),function (Builder $query) use ($attentionTopicIds) {
                $query->whereIn('topic_id',$attentionTopicIds);
            })
            ->when($userIds->isNotEmpty(),function (Builder $query) use ($userIds,$attentionTopicIds) {
                if($attentionTopicIds->isEmpty()) {
                    $query->whereIn('owner_id',$userIds);
                }else{
                    $query->orWhereIn('owner_id',$userIds);
                }
            })
            ->where('circle_id', Constants::STATUS_NOT)
            ->orderByDesc('sort_index')
            ->orderByDesc('last_active_time')
            ->orderByDesc('recommend_weight')
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();

        $this->postListAddReadStatus($list);

        $total = Post::query()->select($selectRows)
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('only_self_visible', Constants::STATUS_NOT)
            ->where('circle_id',Constants::STATUS_NOT)
            ->when($attentionTopicIds->isNotEmpty(),function (Builder $query) use ($attentionTopicIds) {
                $query->whereIn('topic_id',$attentionTopicIds);
            })
            ->when($userIds->isNotEmpty(),function (Builder $query) use ($userIds,$attentionTopicIds) {
                if($attentionTopicIds->isEmpty()) {
                    $query->whereIn('owner_id',$userIds);
                }else{
                    $query->orWhereIn('owner_id',$userIds);
                }
            })
            ->count();

        return ['total'=>$total, 'list'=>$list,'user_count'=>$userIds->count(),'topic_count'=>$attentionTopicIds->count()];
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
            'only_self_visible',
            'rich_content',
            'image_ids',
            'has_video',
            'post.forum_id'
        ];

        if($type == Constants::TOPIC_POST_LIST_SORT_BY_LATEST) {
            $list = Post::query()->select($selectRows)
                ->with(['forum'])
                ->where('topic_id',$topicId)
                ->where('audit_status', Constants::STATUS_DONE)
                ->where('only_self_visible', Constants::STATUS_NOT)
                ->where('circle_id', Constants::STATUS_NOT)
                ->orderByDesc('sort_index')
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
                ->where('circle_id', Constants::STATUS_NOT)
                ->orderByDesc('sort_index')
                ->orderByDesc('recommend_weight')
                ->orderByDesc('last_active_time')
                ->offset($pageIndex * $pageSize)
                ->limit($pageSize)
                ->get();
        }

        $this->postListAddReadStatus($list);

        $total = Post::query()->select($selectRows)
            ->where('topic_id',$topicId)
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('only_self_visible', Constants::STATUS_NOT)
            ->where('circle_id', Constants::STATUS_NOT)
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

    public function getUserAttentionStatus()
    {
        //关注的话题ID
        $attentionTopicIds = UserAttentionTopic::query()->where('user_id',$this->userId())
            ->get()
            ->pluck('topic_id');
        if($attentionTopicIds->count()> 0) {
            return ['status' => 1];
        }
        $userIds = UserAttentionOther::query()->where('user_id',$this->userId())
            ->get()
            ->pluck('other_user_id');
        if($userIds->count()> 0) {
            return ['status' => 1];
        }
        return ['status' => 0];
    }

    public function praiseList(int $pageIndex,int $pageSize)
    {
        $list = UserPraisePost::query()->where('post_owner_id', $this->userId())
            ->with(['post','author'])
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->latest()
            ->get();

        //找出未读Id列表
        $unreadIds = $list->where('owner_read_status',0)->pluck('id');
        $total = UserPraisePost::query()->where('post_owner_id', $this->userId())->count();
        return ['total'=>$total,'list'=>$list,'id_list'=> $unreadIds];
    }

    public function markPraiseRead(array $praiseIds)
    {
        UserPraisePost::query()->whereIn('id', $praiseIds)
            ->where('post_owner_id', $this->userId())
            ->update(['owner_read_status'=>1]);
        return $this->success();
    }

    public function getActivePostByCircleId(int $circleId, int $type, int $pageIndex, int $pageSize)
    {
        if (!isset($type)) {
            $type = Constants::CIRCLE_POST_SORT_LATEST;
        }

        if($type == Constants::FORUM_POST_SORT_LATEST) {
            $list = Post::query()->select($this->activeListRows)
                ->with(['circle'])
                ->where('circle_id',$circleId)
                ->where('audit_status', Constants::STATUS_DONE)
                ->where('only_self_visible', Constants::STATUS_NOT)
                ->orderByDesc('sort_index')
                ->latest()
                ->offset($pageIndex * $pageSize)
                ->limit($pageSize)
                ->get();
        }else{
            $list = Post::query()->select($this->activeListRows)
                ->with(['circle'])
                ->where('circle_id',$circleId)
                ->where('audit_status', Constants::STATUS_DONE)
                ->where('only_self_visible', Constants::STATUS_NOT)
                ->orderByDesc('sort_index')
                ->orderByDesc('recommend_weight')
                ->latest()
                ->offset($pageIndex * $pageSize)
                ->limit($pageSize)
                ->get();
        }

        $this->activePostAddRelationInfo($list);

        $total = Post::query()->select($this->activeListRows)
            ->where('circle_id',$circleId)
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('only_self_visible', Constants::STATUS_NOT)
            ->count();

        return ['total'=>$total, 'list'=>$list];
    }

    public function activePostGetPraiseAndFavoriteStatus($postList)
    {
        $postIds = $postList->pluck('post_id');
        $praiseList = UserPraisePost::query()->where('user_id',$this->userId())
                                             ->whereIn('post_id',$postIds)
                                             ->get()
                                             ->keyBy('post_id');
        $favoriteList = UserFavorite::query()->where('user_id',$this->userId())
                                             ->whereIn('post_id',$postIds)
                                             ->get()
                                             ->keyBy('post_id');
        return [
            'praise' => $praiseList,
            'favorite'=> $favoriteList
        ];
    }

    public function activePostLatestPraise($postList)
    {
        $resultList = [];
        Db::transaction(function () use ($postList, &$resultList){
            $postIds = $postList->pluck('post_id');
            $postIds->map(function ($postId) use (&$resultList){
                $praiseList = UserPraisePost::query()->where('post_id',$postId)
                                                     ->with(['author'])
                                                     ->latest()
                                                     ->limit(6)
                                                     ->get()
                                                     ->pluck('author');
                $resultList[$postId] = $praiseList;
            });
        });
        return $resultList;
    }

    public function activePostLatestComment($postList)
    {
        $resultList = [];
        Db::transaction(function () use ($postList, &$resultList){

            $postIds = $postList->pluck('post_id');

            $postIds->map(function ($postId) use (&$resultList){
               $commentList = Comment::query()->where('post_id',$postId)
                                          ->with(['parent_comment'])
                                          ->latest()
                                          ->limit(3)
                                          ->get();
               $commentList->map(function (Comment $comment) {
                   if (isset($comment->image_list) && is_string($comment->image_list)) {
                       $comment->image_list = explode(';', $comment->image_list);
                   }
                   return $comment;
               });
               $resultList[$postId] = $commentList;
            });
        });
        return $resultList;
    }

    public function deleteActivePost(int $postId,int $circleId)
    {
        $user = User::query()->where('user_id',$this->userId())
                             ->first();
        if(!$user instanceof User) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }
        if($user->role_id < Constants::USER_ROLE_ADMIN) {
            //是不是圈主
            $circle = Circle::findOrFail($circleId);
            if($circle->owner_id != $this->userId()) {
                //是不是自己的
                $post = Post::findOrFail($postId);
                if($post->owner_id !== $user->user_id) {
                    throw new HyperfCommonException(ErrorCode::NO_PERMISSION_DELETE_POST);
                }
            }
        }
        Post::query()->where('post_id',$postId)->delete();
        return $this->success();
    }

    public function getActivePostByCircleTopicId(int $topicId, int $pageIndex, int $pageSize, $type)
    {
        if (!isset($type)) {
            $type = Constants::CIRCLE_POST_SORT_LATEST;
        }

        if ($type == Constants::FORUM_POST_SORT_LATEST) {
            $list = Post::query()->select($this->activeListRows)
                ->with(['circle'])
                ->where('circle_topic_id', $topicId)
                ->where('audit_status', Constants::STATUS_DONE)
                ->where('only_self_visible', Constants::STATUS_NOT)
                ->orderByDesc('sort_index')
                ->latest()
                ->offset($pageIndex * $pageSize)
                ->limit($pageSize)
                ->get();
        } else {
            $list = Post::query()->select($this->activeListRows)
                ->with(['circle'])
                ->where('circle_topic_id', $topicId)
                ->where('audit_status', Constants::STATUS_DONE)
                ->where('only_self_visible', Constants::STATUS_NOT)
                ->orderByDesc('sort_index')
                ->orderByDesc('recommend_weight')
                ->latest()
                ->offset($pageIndex * $pageSize)
                ->limit($pageSize)
                ->get();
        }

        $this->activePostAddRelationInfo($list);

        $total = Post::query()->select($this->activeListRows)
            ->where('circle_topic_id', $topicId)
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('only_self_visible', Constants::STATUS_NOT)
            ->count();

        return ['total' => $total, 'list' => $list];
    }

    public function activePostAddRelationInfo(&$list)
    {
        $this->postListAddReadStatus($list);

        $commentList = $this->activePostLatestComment($list);
        $praiseList = $this->activePostLatestPraise($list);
        if(Auth::isGuest() == false){
            $praiseAndFavoriteStatusList = $this->activePostGetPraiseAndFavoriteStatus($list);
        }else{
            $praiseAndFavoriteStatusList = [];
        }
        $list->map(function (Post $post) use ($commentList,$praiseList,$praiseAndFavoriteStatusList){
            if(isset($commentList[$post->post_id])){
                $post->comment_list = $commentList[$post->post_id];
            }else{
                $post->comment_list = [];
            }
            if(isset($praiseList[$post->post_id])) {
                $post->praise_list = $praiseList[$post->post_id];
            }else{
                $post->praise_list = [];
            }
            if(!empty($praiseAndFavoriteStatusList)) {
                $praiseStatusList = $praiseAndFavoriteStatusList['praise'];
                $favoriteStatusList = $praiseAndFavoriteStatusList['favorite'];
                if(isset($praiseStatusList[$post->post_id])) {
                    $post->is_praise = 1;
                }else{
                    $post->is_praise = 0;
                }
                if(isset($favoriteStatusList[$post->post_id])) {
                    $post->is_favorite = 1;
                }else{
                    $post->is_favorite = 0;
                }
            }else{
                $post->is_praise = 0;
                $post->is_favorite = 0;
            }
            return $post;
        });
    }

    public function getActivePostDetail(int $postId)
    {
        $list = Post::query()->where('post_id',$postId)
            ->with(['circle'])
            ->get();
        $this->activePostAddRelationInfo($list);
        return $list;
    }

    public function getActivePostByUserId(int $pageIndex, int $pageSize, int $userId = null)
    {
        if (!isset($userId)) {
            $userId = $this->userId();
        }

        $list = Post::query()->select($this->activeListRows)
            ->with(['circle'])
            ->where('circle_id','>',Constants::STATUS_NOT)
            ->where('owner_id', $userId)
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('only_self_visible', Constants::STATUS_NOT)
            ->orderByDesc('sort_index')
            ->latest()
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();

        $this->activePostAddRelationInfo($list);

        $total = Post::query()->select($this->activeListRows)
            ->where('circle_id','>',Constants::STATUS_NOT)
            ->where('owner_id', $userId)
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('only_self_visible', Constants::STATUS_NOT)
            ->count();

        return ['total' => $total, 'list' => $list];
    }

    public function getActivePostByAttention(int $pageIndex, int $pageSize)
    {
        $userIds = UserAttentionOther::query()->where('user_id',$this->userId())
            ->get()
            ->pluck('other_user_id');

        if($userIds->isEmpty()) {
            return ['total' => 0, 'list' => []];
        }

        $list = Post::query()->select($this->activeListRows)
            ->with(['circle'])
            ->whereIn('owner_id',$userIds)
            ->where('circle_id','>',Constants::STATUS_NOT)
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('only_self_visible', Constants::STATUS_NOT)
            ->orderByDesc('sort_index')
            ->latest()
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();

        $this->activePostAddRelationInfo($list);

        $total = Post::query()->select($this->activeListRows)
            ->whereIn('owner_id',$userIds)
            ->where('circle_id','>',Constants::STATUS_NOT)
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('only_self_visible', Constants::STATUS_NOT)
            ->count();

        return ['total' => $total, 'list' => $list];
    }
}