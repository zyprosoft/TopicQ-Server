<?php


namespace App\Service\Admin;
use App\Constants\Constants;
use App\Job\AddNotificationJob;
use App\Model\Post;
use App\Model\ReportPost;
use App\Service\BaseService;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;

class PostService extends BaseService
{
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

    protected function innerAuditPost(int $postId, int $status, string $note = null, bool $isReport = false)
    {
        $post = Post::query()->where('post_id', $postId)
            ->lockForUpdate()
            ->first();
        if(!$post instanceof Post) {
            throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
        }
        if ($post->audit_status != Constants::STATUS_WAIT) {
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
            $report = ReportPost::findOrFail($reportId);
            $report->audit_status = $status;
            if (isset($note)) {
                $report->audit_note = $note;
            }
            $report->saveOrFail();
            $this->innerAuditPost($postId, $status, $note, true);

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
}