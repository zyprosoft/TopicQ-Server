<?php


namespace App\Controller\Admin;
use App\Http\AppAdminRequest;
use App\Http\AppManagerRequest;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\PostService;

/**
 * @AutoController (prefix="/admin/post")
 * Class PostController
 * @package App\Controller\Admin
 */
class PostController extends AbstractController
{
    /**
     * @Inject
     * @var PostService
     */
    protected PostService $service;

    public function waitAuditList(AppAdminRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
            'postId' => 'integer|exists:post,post_id'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $postId = $request->param('postId');
        $result = $this->service->getWaitAuditPostList($pageIndex,$pageSize,$postId);
        return $this->success($result);
    }

    public function audit(AppAdminRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
            'status' => 'integer|required|in:-1,1',
            'note' => 'string|min:1|max:64'
        ]);
        $postId = $request->param('postId');
        $status = $request->param('status');
        $note = $request->param('note');
        $result = $this->service->audit($postId, $status, $note);
        return $this->success($result);
    }

    public function manageBlock(AppManagerRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
            'status' => 'integer|required|in:-1,1',
            'note' => 'string|min:1|max:64'
        ]);
        $postId = $request->param('postId');
        $status = $request->param('status');
        $note = $request->param('note');
        $result = $this->service->audit($postId, $status, $note);
        return $this->success($result);
    }

    public function getPostReportList(AppAdminRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
            'reportId' => 'integer|exists:report_post,id'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $reportId = $request->param('reportId');
        $result = $this->service->getPostReportList($pageIndex, $pageSize, $reportId);
        return $this->success($result);
    }

    public function auditReport(AppAdminRequest $request)
    {
        $this->validate([
            'reportId' => 'integer|required|exists:report_post,id',
            'postId' => 'integer|required|exists:post,post_id',
            'status' => 'integer|required|in:-1,1',
            'note' => 'string|min:1|max:64'
        ]);
        $postId = $request->param('postId');
        $status = $request->param('status');
        $note = $request->param('note');
        $reportId = $request->param('reportId');
        $result = $this->service->auditReport($reportId, $postId, $status, $note);
        return $this->success($result);
    }

    public function recommend(AppAdminRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
            'status' => 'integer|required|in:0,1'
        ]);
        $postId = $request->param('postId');
        $status = $request->param('status');
        $result = $this->service->recommend($postId, $status);
        return $this->success($result);
    }

    public function hot(AppAdminRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
            'status' => 'integer|required|in:0,1'
        ]);
        $postId = $request->param('postId');
        $status = $request->param('status');
        $result = $this->service->hot($postId, $status);
        return $this->success($result);
    }

    public function sortUp(AppAdminRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
            'status' => 'integer|required|in:0,1'
        ]);
        $postId = $request->param('postId');
        $status = $request->param('status');
        $result = $this->service->sortUp($postId, $status);
        return $this->success($result);
    }
}