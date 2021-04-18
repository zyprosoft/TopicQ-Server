<?php


namespace App\Service\Admin;
use App\Model\ReportComment;
use App\Service\BaseService;
use Hyperf\Database\Model\Builder;

class ReportService extends BaseService
{
    public function getCommentReportList(int $pageIndex, int $pageSize, int $lastReportId = null)
    {
        $list = ReportComment::query()->where(function (Builder $query) use ($lastReportId) {
            if(isset($lastReportId)) {
                $query->where('id','>',$lastReportId);
            }
        })->offset($pageIndex * $pageSize)->offset($pageSize);

    }
}