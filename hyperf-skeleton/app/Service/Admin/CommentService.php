<?php


namespace App\Service\Admin;
use App\Constants\Constants;
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
        $list = ReportComment::query()->where('audit_status',Constants::STATUS_WAIT)
            ->where(function (Builder $query) use ($lastReportId) {
            if(isset($lastReportId)) {
                $query->where('id','>',$lastReportId);
            }
        })->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->latest()
            ->get();
        $total = ReportComment::query()->where('audit_status',Constants::STATUS_WAIT)->count();
        return ['list'=>$list, 'total'=>$total];
    }

    public function audit(int $reportId, int $commentId, int $status, string $note = null)
    {
        Db::transaction(function () use ($reportId, $commentId, $status, $note){
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
           return $this->success();
        });
    }
}