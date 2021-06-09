<?php


namespace App\Service\Admin;
use App\Constants\Constants;
use App\Job\AddNotificationJob;
use App\Job\AddScoreJob;
use App\Model\ManagerAvatarUser;
use App\Model\Post;
use App\Model\ReportPost;
use App\Model\UserRead;
use App\Service\BaseService;
use App\Service\NotificationService;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Facade\Auth;
use Hyperf\Di\Annotation\Inject;

class PostService extends BaseService
{
    /**
     * @Inject
     * @var NotificationService
     */
    protected NotificationService $notificationService;

    public function deletePost(int $postId)
    {
        $post = Post::findOrFail($postId);
        $post->delete();

        //发送一条通知
        $title = '帖子被删除';
        $content = '您好，您的帖子被管理员认为不符合社区当前的文化氛围，已将您的帖子删除，敬请谅解，感谢您对社区文化构建的积极参与~';
        $level = Constants::MESSAGE_LEVEL_WARN;
        $levelLabel = '通知';
        $this->notificationService->create($post->owner_id,$title,$content,false,$level,$levelLabel);

        return $this->success();
    }

    public function searchPost(string $keyword,int $pageIndex, int $pageSize)
    {
        $list = Post::query()
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('title','like',"%$keyword%")
            ->orWhere('content','like',"%$keyword%")
            ->offset($pageIndex * $pageSize)
                             ->limit($pageSize)
                             ->get();

        //补充星标用户信息
        $ownerIdList = collect($list)->pluck('owner_id')->unique();
        $userList = ManagerAvatarUser::query()->whereIn('avatar_user_id',$ownerIdList)
            ->get()
            ->keyBy('avatar_user_id');
        $list->map(function (Post $post) use ($userList) {
            if(isset($userList[$post->owner_id])) {
                $post->is_star = 0;
            }else{
                $post->is_star = 1;
            }
            return $post;
        });

        $total = Post::query()
            ->where('audit_status', Constants::STATUS_DONE)
            ->where('title','like',"%$keyword%")
            ->orWhere('content','like',"%$keyword%")
            ->count();
        
        return ['total'=>$total,'list'=>$list];
    }

    public function waitOperatePostList(int $pageIndex, int $pageSize)
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
            'forum_id'
        ];

        $list = Post::query()->select($selectRows)
            ->where('audit_status', Constants::STATUS_DONE)
            ->with(['forum'])
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
            ->where('audit_status', Constants::STATUS_DONE)
            ->count();

        //补充星标用户信息
        $ownerIdList = collect($list)->pluck('owner_id')->unique();
        $userList = ManagerAvatarUser::query()->whereIn('avatar_user_id',$ownerIdList)
                                              ->get()
                                              ->keyBy('avatar_user_id');
        $list->map(function (Post $post) use ($userList) {
            if(isset($userList[$post->owner_id])) {
                $post->is_star = 0;
            }else{
                $post->is_star = 1;
            }
            return $post;
        });

        return ['list'=>$list,'total'=>$total];
    }

    public function getWaitAuditPostList(int $pageIndex, int $pageSize, int $lastPostId = null)
    {
        $list = Post::query()->where('audit_status',Constants::STATUS_WAIT)
                             ->where(function (Builder $query) use ($lastPostId){
                                 if(isset($lastPostId)) {
                                     $query->where('post_id','<', $lastPostId);
                                 }
                             })
                             ->latest()
                             ->offset($pageIndex * $pageSize)
                             ->limit($pageSize)
                             ->get();
        $total = Post::query()->where('audit_status',Constants::STATUS_WAIT)->count();

        return ['total'=>$total, 'list'=>$list];
    }

    public function getPostReportList(int $pageIndex, int $pageSize, int $lastReportId = null)
    {
        $list = ReportPost::query()->where('audit_status',Constants::STATUS_WAIT)
            ->where(function (Builder $query) use ($lastReportId) {
                if(isset($lastReportId)) {
                    $query->where('id','<',$lastReportId);
                }
            })->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->latest()
            ->get();
        $total = ReportPost::query()->where('audit_status',Constants::STATUS_WAIT)->count();
        return ['list'=>$list, 'total'=>$total];
    }

    public function audit(int $postId, int $status, string $note = null)
    {
        Db::transaction(function () use ($postId, $status, $note){
            $this->innerAuditPost($postId, $status, $note);
        });
        return $this->success();
    }

    //必须在事务中执行
    protected function innerAuditPost(int $postId, int $status, string $note = null, bool $isReport = false)
    {
        $post = Post::query()->where('post_id', $postId)
            ->lockForUpdate()
            ->first();
        if(!$post instanceof Post) {
            throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
        }

        //已经审核过了，但是可以关闭
        if ($post->audit_status != Constants::STATUS_WAIT && $post->audit_status == $status) {
            return $this->success();
        }
        $post->audit_status = $status;
        if ((isset($note))) {
            $post->audit_note = $note;
        }
        $post->saveOrFail();

        //被举报，但是被管理员认定没有违规，无需发送任何通知
        if($isReport && $status == Constants::STATUS_DONE) {
            return $this->success();
        }

        if($isReport && $status == Constants::STATUS_INVALIDATE) {
            $title = '帖子被举报处理结果';
            $content = "您的帖子《{$post->title}》被举报，经管理员审核情况属实，现已将帖子拉黑，请规范您的社区行为，若多次被举报并属实将进入社区永久黑名单。";
            $levelLabel = '警告';
            $level = Constants::MESSAGE_LEVEL_BLOCK;
        }else{
            if($status == Constants::STATUS_DONE) {
                $level = Constants::MESSAGE_LEVEL_NORMAL;
                $levelLabel = '通知';
            }else{
                $levelLabel = '警告';
                $level = Constants::MESSAGE_LEVEL_BLOCK;
            }
            $title = '帖子审核结果';
            $statusLabel = $status==Constants::STATUS_DONE?'通过':'拒绝';
            $content = "您的帖子《{$post->title}》已被管理员审核".$statusLabel;
        }
        $notification = new AddNotificationJob($post->owner_id,$title,$content,false,$level);
        $notification->levelLabel = $levelLabel;
        $notification->keyInfo = json_encode(['post_id'=>$postId]);
        $this->push($notification);

        return $this->success();
    }

    public function auditReport(int $reportId,int $postId, int $status, string $note = null)
    {
        Db::transaction(function () use ($reportId, $postId, $status, $note){
            $report = ReportPost::query()->where('id',$reportId)->lockForUpdate()->first();
            if(!$report instanceof ReportPost) {
                throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
            }
            if($report->audit_status !== Constants::STATUS_WAIT) {
                throw new HyperfCommonException(ErrorCode::PARAM_ERROR);
            }
            $report->audit_status = $status;
            if (isset($note)) {
                $report->audit_note = $note;
            }
            $this->innerAuditPost($postId, $status, $note, true);
            $report->saveOrFail();

            if ($status == Constants::STATUS_INVALIDATE) {
                $post = Post::find($postId);
                //给举报者发一条信息
                $title = "评论举报成功";
                $content = "您举报的帖子《{$post->title}》经管理员审核查阅，已被认定违反社区参与规范，现已将该帖子删除屏蔽，感谢您对社区内容净化的大力支持~";
                $notification = new AddNotificationJob($report->owner_id,$title,$content,false,Constants::MESSAGE_LEVEL_NORMAL);
                $notification->levelLabel = "通知";
                $notification->keyInfo = json_encode(['post_id'=>$postId]);
                $this->push($notification);
            }

        });
        return $this->success();
    }

    protected function postUpdate(int $postId, string $column, int $value)
    {
        Db::transaction(function () use ($postId, $column, $value) {
            $post = Post::query()->where('post_id', $postId)
                ->lockForUpdate()
                ->first();
            if (!$post instanceof Post) {
                throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
            }
            data_set($post,$column,$value);
            $post->saveOrFail();

            //增加一条异步通知
            $map = [
                'is_recommend_0' => '取消推荐',
                'is_recommend_1' => '设为推荐',
                'is_hot_1' => '设为热帖',
                'is_hot_0' => '取消热帖',
                'sort_index_0' => '取消置顶',
                'sort_index_1' => '设置置顶'
            ];
            $key = $column.'_'.$value;
            $title = '帖子被'.$map[$key];
            $content = "您的帖子《{$post->title}》已被管理员".$map[$key];
            $notification = new AddNotificationJob($post->owner_id,$title,$content,false,Constants::MESSAGE_LEVEL_WARN);
            $notification->levelLabel = "通知";
            $notification->keyInfo = json_encode(['post_id'=>$postId]);
            $this->push($notification);

            //增加积分
            if ($column == 'is_recommend' && $value == 1) {
                $scoreDesc = "帖子被设为推荐《{$post->title}》";
                $this->push(new AddScoreJob($post->owner_id,Constants::SCORE_ACTION_POST_RECOMMEND,$scoreDesc));
            }

            if($column == 'sort_index' && $value == 1) {
                $scoreDesc = "帖子被设为置顶《{$post->title}》";
                $this->push(new AddScoreJob($post->owner_id,Constants::SCORE_ACTION_POST_SORT_UP,$scoreDesc));
            }

            return $this->success();
        });
        return $this->success();
    }

    public function recommend(int $postId, int $status)
    {
        $this->postUpdate($postId,'is_recommend',$status);
    }

    public function sortUp(int $postId, int $status)
    {
        $this->postUpdate($postId,'sort_index',$status);
    }

    public function hot(int $postId, int $status)
    {
        $this->postUpdate($postId,'is_hot',$status);
    }

    public function updateRecommendWeight(int $postId, int $weight)
    {
        $post = Post::findOrFail($postId);
        $post->recommend_weight = $weight;
        $post->ignore_machine_recommend = 1;//忽略机器计算权重
        $post->saveOrFail();
    }

    public function updateReadCount(int $postId, int $readCount)
    {
        $post = Post::findOrFail($postId);
        $post->read_count = $readCount;
        $post->saveOrFail();
    }

    public function getMaxRecommendWeight()
    {
        return Post::query()->max('recommend_weight');
    }

    public function updateForum(int $postId, int $forumId)
    {
        $post = Post::findOrFail($postId);
        $post->forum_id = $forumId;
        $post->saveOrFail();
    }
}