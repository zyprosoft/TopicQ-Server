<?php


namespace App\Service\Admin;

use App\Constants\Constants;
use App\Job\AddNotificationJob;
use App\Model\Comment;
use App\Model\ReportComment;
use App\Service\BaseService;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;

class CommentService extends BaseService
{
    public function getCommentReportList(int $pageIndex, int $pageSize, int $lastReportId = null)
    {
        $list = ReportComment::query()->where('audit_status', Constants::STATUS_WAIT)
            ->where(function (Builder $query) use ($lastReportId) {
                if (isset($lastReportId)) {
                    $query->where('id', '<', $lastReportId);
                }
            })->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->latest()
            ->get();
        $total = ReportComment::query()->where('audit_status', Constants::STATUS_WAIT)->count();
        return ['list' => $list, 'total' => $total];
    }

    public function audit(int $reportId, int $commentId, int $status, string $note = null)
    {
        Db::transaction(function () use ($reportId, $commentId, $status, $note) {
            $comment = Comment::query()->where('comment_id', $commentId)
                ->first();
            if (!$comment instanceof Comment) {
                throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
            }
            $comment->audit_status = $status;
            if (isset($note)) {
                $comment->audit_note = $note;
            }
            $comment->saveOrFail();
            $reportComment = ReportComment::findOrFail($reportId);
            $reportComment->audit_status = $status;
            if (isset($note)) {
                $reportComment->audit_note = $note;
            }
            $reportComment->saveOrFail();
            //增加一条举报成功处理通知
            if ($status == Constants::STATUS_INVALIDATE) {
                $title = "评论被举报处理结果";
                $content = "您发表的评论内容《{$comment->content}》经管理员审核查阅，已被认定违反社区参与规范，现已将该评论删除屏蔽，请严格按照社区规范参与发表自己的评论，若多次被举报违规属实，将永久纳入社区黑名单。";
                $notification = new AddNotificationJob($comment->owner_id,$title,$content,false,Constants::MESSAGE_LEVEL_BLOCK);
                $notification->levelLabel = "警告";
                $notification->keyInfo = json_encode(['comment_id'=>$commentId]);
                $this->push($notification);

                //给举报者发一条信息
                $title = "评论举报成功";
                $content = "您举报的评论内容《{$comment->content}》经管理员审核查阅，已被认定违反社区参与规范，现已将该评论删除屏蔽，感谢您对社区内容净化的大力支持~";
                $notification = new AddNotificationJob($reportComment->owner_id,$title,$content,false,Constants::MESSAGE_LEVEL_NORMAL);
                $notification->levelLabel = "通知";
                $notification->keyInfo = json_encode(['comment_id'=>$commentId]);
                $this->push($notification);
            }else{
                //给举报者发一条信息
                $title = "评论举报驳回";
                $content = "您举报的评论内容《{$comment->content}》经管理员审核查阅，您的举报理由不符合事实，请知悉，如有更多疑问请联系管理员，感谢您对社区内容净化的大力支持~";
                $notification = new AddNotificationJob($reportComment->owner_id,$title,$content,false,Constants::MESSAGE_LEVEL_NORMAL);
                $notification->levelLabel = "通知";
                $notification->keyInfo = json_encode(['comment_id'=>$commentId]);
                $this->push($notification);
            }
            return $this->success();
        });
    }

    public function managerBlock(int $commentId)
    {
        $comment = null;
        Db::transaction(function () use ($commentId, &$comment) {
            $comment = Comment::query()->where('comment_id', $commentId)
                ->lockForUpdate()
                ->first();
            if (!$comment instanceof Comment) {
                throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
            }
            $comment->audit_status = Constants::STATUS_INVALIDATE;
            $comment->audit_note = "被管理员击飞";
            $comment->saveOrFail();
        });
        if (!$comment instanceof Comment) {
            throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
        }
        //增加一条审核成功处理通知
        $title = "评论被管理员审核不通过";
        $content = "您发表的评论内容《{$comment->content}》经管理员审核查阅，已被认定违反社区参与规范，现已将该评论删除屏蔽，请严格按照社区规范参与发表自己的评论，若多次被管理员击飞评论，将永久纳入社区黑名单。";
        $notification = new AddNotificationJob($comment->owner_id,$title,$content,false,Constants::MESSAGE_LEVEL_BLOCK);
        $notification->levelLabel = "警告";
        $notification->keyInfo = json_encode(['comment_id'=>$commentId]);
        $this->push($notification);
        return $this->success();
    }
}