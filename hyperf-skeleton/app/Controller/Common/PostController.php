<?php


namespace App\Controller\Common;
use ZYProSoft\Controller\AbstractController;
use ZYProSoft\Http\AuthedRequest;
use App\Service\PostService;
use  Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;

/**
 * @AutoController (prefix="/common/post")
 * Class PostController
 * @package App\Controller\Common
 */
class PostController extends AbstractController
{
    /**
     * @Inject
     * @var PostService
     */
    private PostService $service;

    public function create(AuthedRequest $request)
    {
        $this->validate([
            'title' => 'string|required|min:1|max:32|sensitive',
            'content' => 'string|required|min:10|max:5000|sensitive',
            'imageList' => 'array|min:1|max:4',
            'link' => 'string|min:1|max:500|sensitive',
            'vote' => 'array|min:1',
            'vote.subject' => 'string|required|min:1|max:32|sensitive',
            'vote.items.*.content' => 'string|required|min:1|max:32|sensitive'
        ]);
        $params = $request->getParams();
        $result = $this->service->create($params);
        return $this->success($result);
    }

    public function detail()
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
        ]);
        $postId = $this->request->param('postId');
        $result = $this->service->detail($postId);
        return $this->success($result);
    }

    public function list()
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
            'type' => 'integer|required|in:1,2,3',
        ]);
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $type = $this->request->param('type');
        $result = $this->service->getList($type, $pageIndex, $pageSize);
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
        $result = $this->service->getUserPostList($pageIndex, $pageSize);
        return $this->success($result);
    }
}