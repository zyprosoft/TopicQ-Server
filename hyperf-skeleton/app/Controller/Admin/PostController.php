<?php


namespace App\Controller\Admin;
use App\Http\AppAdminRequest;
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

    public function recommend(AppAdminRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
        ]);
        $postId = $request->param('postId');
        $result = $this->service->recommend($postId);
        return $this->success($result);
    }

    public function hot(AppAdminRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
        ]);
        $postId = $request->param('postId');
        $result = $this->service->hot($postId);
        return $this->success($result);
    }

    public function sortUp(AppAdminRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
        ]);
        $postId = $request->param('postId');
        $result = $this->service->sortUp($postId);
        return $this->success($result);
    }
}