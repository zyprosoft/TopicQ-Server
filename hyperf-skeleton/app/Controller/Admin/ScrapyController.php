<?php


namespace App\Controller\Admin;
use App\Http\AppAdminRequest;
use ZYProSoft\Controller\AbstractController;
use App\Service\Scrapy\PostService;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;

/**
 * @AutoController (prefix="/admin/spost")
 * Class ScrapyController
 * @package App\Controller\Admin
 */
class ScrapyController extends AbstractController
{
    /**
     * @Inject
     * @var PostService
     */
    protected PostService $service;

    public function searchPost(AppAdminRequest $request)
    {
        $this->validate([
            'sessionHash' => 'string|required|min:1',
            'pageIndex' => 'integer|required|min:0'
        ]);
        $sessionHash = $request->param('sessionHash');
        $pageIndex = $request->param('pageIndex');
        $result = $this->service->getPostList($pageIndex,$sessionHash);
        return $this->success($result);
    }

    public function getCommentList(AppAdminRequest $request)
    {
        $this->validate([
            'postId' => 'string|required|exists:thread,thread_id',
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30'
        ]);
        $postId = $request->param('postId');
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->getCommentList($postId,$pageIndex,$pageSize);
        return $this->success($result);
    }

    public function addDelayPostTask(AppAdminRequest $request)
    {
        $this->validate([
            'postId' => 'string|required',
            'forumId' => 'integer|required_without:circleId|exists:forum,forum_id',
            'circleId' => 'integer|required_without:forumId|exists:circle,circle_id',
            'sessionHash' => 'string|required|min:1',
        ]);
        $postId = $request->param('postId');
        $forumId = $request->param('forumId');
        $circleId = $request->param('circleId');
        $sessionHash= $request->param('sessionHash');
        $result = $this->service->addDelayPost($postId,$sessionHash,$forumId,$circleId);
        return $this->success($result);
    }
}