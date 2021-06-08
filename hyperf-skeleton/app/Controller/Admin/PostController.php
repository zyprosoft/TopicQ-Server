<?php


namespace App\Controller\Admin;
use App\Constants\Constants;
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

    public function deletePost(AppAdminRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id'
        ]);
        $postId = $request->param('postId');
        $result = $this->service->deletePost($postId);
        return $this->success($result);
    }

    public function searchPost(AppAdminRequest $request)
    {
        $this->validate([
            'keyword' => 'string|required|min:1|max:20',
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30'
        ]);
        $keyword = $request->param('keyword');
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->searchPost($keyword,$pageIndex,$pageSize);
        return $this->success($result);
    }

    public function waitOperatePostList(AppAdminRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->waitOperatePostList($pageIndex,$pageSize);
        return $this->success($result);
    }

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

    public function managerBlock(AppManagerRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
        ]);
        $postId = $request->param('postId');
        $status = Constants::STATUS_INVALIDATE;
        $note = "管理员主动打回";
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

    public function getMaxRecommendWeight(AppAdminRequest $request)
    {
        $result = $this->service->getMaxRecommendWeight();
        return $this->success($result);
    }

    public function updatePostRecommendWeight(AppAdminRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
            'weight' => 'integer|required|min:0'
        ]);
        $postId = $request->param('postId');
        $weight = $request->param('weight');
        $result = $this->service->updateRecommendWeight($postId,$weight);
        return $this->success($result);
    }

    public function updateReadCount(AppAdminRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
            'readCount' => 'integer|required|min:0'
        ]);
        $postId = $request->param('postId');
        $readCount = $request->param('readCount');
        $result = $this->service->updateReadCount($postId,$readCount);
        return $this->success($result);
    }

    public function updateForum(AppAdminRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
            'forumId' => 'integer|required|exists:forum,forum_id'
        ]);
        $postId = $request->param('postId');
        $forumId = $request->param('forumId');
        $result = $this->service->updateForum($postId,$forumId);
        return $this->success($result);
    }
}