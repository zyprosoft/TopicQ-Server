<?php


namespace App\Controller\Common;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\CommentService;
use ZYProSoft\Http\AuthedRequest;

/**
 * @AutoController (prefix="/common/comment")
 * Class CommentController
 * @package App\Controller\Common
 */
class CommentController extends AbstractController
{
    /**
     * @Inject
     * @var CommentService
     */
    private CommentService $service;

    public function create(AuthedRequest $request)
    {
        $this->validate([
            'content' => 'string|required|min:1|max:500|sensitive',
            'postId' => 'integer|required|min:1|exists:post,post_id',
            'imageList' => 'array|min:1|max:4',
            'link' => 'string|min:1|max:500'
        ]);
        $postId = $request->param('postId');
        $imageList = $request->param('imageList');
        $content = $request->param('content');
        $link = $request->param('link');
        $result = $this->service->create($postId, $content, $imageList, $link);
        return $this->success($result);
    }

    public function detail()
    {
        $this->validate([
            'commentId' => 'integer|required|min:1|exists:comment,comment_id',
        ]);
        $commentId = $this->request->param('commentId');
        $result = $this->service->delete($commentId);
        return $this->success($result);
    }

    public function reply(AuthedRequest $request)
    {
        $this->validate([
            'content' => 'string|required|min:1|max:500|sensitive',
            'commentId' => 'integer|required|min:1|exists:comment,comment_id',
            'imageList' => 'array|min:1|max:4',
            'link' => 'string|min:1|max:500'
        ]);
        $commentId = $request->param('commentId');
        $imageList = $request->param('imageList');
        $content = $request->param('content');
        $link = $request->param('link');
        $result = $this->service->reply($commentId, $content, $imageList, $link);
        return $this->success($result);
    }

    public function list()
    {
        $this->validate([
            'postId' => 'integer|required|min:1|exists:post,post_id',
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
            'type' => 'integer|required|in:1,2,3',
        ]);
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $type = $this->request->param('type');
        $postId = $this->request->param('postId');
        $result = $this->service->getList($postId, $pageIndex, $pageSize, $type);
        return $this->success($result);
    }

    public function listByUser(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->getUserCommentList($pageIndex, $pageSize);
        return $this->success($result);
    }

    public function praise(AuthedRequest $request)
    {
        $this->validate([
            'commentId' => 'integer|required|min:1|exists:comment,comment_id',
        ]);
        $commentId = $request->param('commentId');
        $result = $this->service->praise($commentId);
        return $this->success($result);
    }

    public function commentReplyList()
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
            'commentId' => 'integer|required|min:1|exists:comment,comment_id',
        ]);
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $commentId = $this->request->param('commentId');
        $result = $this->service->commentReplyList($commentId, $pageIndex, $pageSize);
        return $this->success($result);
    }

    public function userReplyList(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->userReplyList($pageIndex, $pageSize);
        return $this->success($result);
    }

    public function report(AuthedRequest $request)
    {
        $this->validate([
            'commentId' => 'integer|required|exists:comment,comment_id',
            'content' => 'string|required|min:1|max:500'
        ]);
        $commentId = $request->param('commentId');
        $content = $request->param('content');
        $result = $this->service->reportComment($commentId, $content);
        return $this->success($result);
    }

    public function markRead(AuthedRequest $request)
    {
        $this->validate([
            'commentIds' => 'array|required|min:1',
        ]);
        $commentIds = $request->param('commentIds');
        $result = $this->service->markRead($commentIds);
        return $this->success($result);
    }
}