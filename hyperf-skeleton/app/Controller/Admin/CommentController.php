<?php


namespace App\Controller\Admin;
use App\Http\AppAdminRequest;
use App\Http\AppManagerRequest;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\CommentService;

/**
 * @AutoController (prefix="/admin/comment")
 * Class CommentController
 * @package App\Controller\Admin
 */
class CommentController extends AbstractController
{
    /**
     * @inject
     * @var CommentService
     */
    protected CommentService $service;

    public function getCommentReportList(AppAdminRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
            'reportId' => 'integer|exists:report_comment,id'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $reportId = $request->param('reportId');
        $result = $this->service->getCommentReportList($pageIndex,$pageSize,$reportId);
        return $this->success($result);
    }

    public function audit(AppAdminRequest $request)
    {
        $this->validate([
            'reportId' => 'integer|required|exists:report_comment,id',
            'commentId' => 'integer|required|exists:comment,comment_id',
            'status' => 'integer|required|in:-1,1',
            'note' => 'string|min:1|max:64'
        ]);
        $commentId = $request->param('commentId');
        $status = $request->param('status');
        $note = $request->param('note');
        $reportId = $request->param('reportId');
        $result = $this->service->audit($reportId, $commentId, $status, $note);
        return $this->success($result);
    }

    public function managerBlock(AppManagerRequest $request)
    {
        $this->validate([
            'reportId' => 'integer|required|exists:report_comment,id',
            'commentId' => 'integer|required|exists:comment,comment_id',
            'status' => 'integer|required|in:-1,1',
            'note' => 'string|min:1|max:64'
        ]);
        $commentId = $request->param('commentId');
        $status = $request->param('status');
        $note = $request->param('note');
        $reportId = $request->param('reportId');
        $result = $this->service->audit($reportId, $commentId, $status, $note);
        return $this->success($result);
    }
}