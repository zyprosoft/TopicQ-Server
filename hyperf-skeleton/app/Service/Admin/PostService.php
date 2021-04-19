<?php


namespace App\Service\Admin;
use App\Constants\Constants;
use App\Model\Post;
use App\Model\ReportPost;
use App\Service\BaseService;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;
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

    protected function innerAuditPost(int $postId, int $status, string $note = null)
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
            $this->innerAuditPost($postId, $status, $note);
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
            if ($post->audit_status != Constants::STATUS_WAIT) {
                return $this->success();
            }
            $post->$column = $value;
            $post->saveOrFail();
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