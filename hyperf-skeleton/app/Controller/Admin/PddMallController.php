<?php


namespace App\Controller\Admin;
use App\Http\AppAdminRequest;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\PddService;
use ZYProSoft\Http\AuthedRequest;

/**
 * @AutoController (prefix="/admin/pdd")
 * Class MallController
 * @package App\Controller\Common
 */
class PddMallController extends AbstractController
{
    /**
     * @Inject
     * @var PddService
     */
    protected PddService $service;

    public function search(AppAdminRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:1',
            'pageSize' => 'integer|required|min:10|max:30',
            'keyword' => 'string|required|min:1',
            'optId' => 'integer',
            'listId' => 'string|min:1'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $keyword = $request->param('keyword');
        $optId = $request->param('optId');
        $listId = $request->param('listId');
        $result = $this->service->search($keyword,$pageIndex,$pageSize,$listId,$optId);
        return $this->success($result);
    }

    public function recommend(AppAdminRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:1',
            'pageSize' => 'integer|required|min:10|max:30',
            'listId' => 'string|min:1'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $listId = $request->param('listId');
        $result = $this->service->recommendList($pageIndex, $pageSize, $listId);
        return $this->success($result);
    }

    public function createPost(AppAdminRequest $request)
    {
        $this->validate(
            [
                'title' => 'string|required|min:1|max:40|sensitive',
                'content' => 'string|required|min:1|max:5000|sensitive',
                'imageList' => 'array|min:1|max:4',
                'link' => 'string|min:1|max:500',
                'goodsInfo' => 'array|required',
                'forumId' => 'integer|exists:forum,forum_id'
            ]
        );
        $title = $request->param('title');
        $content = $request->param('content');
        $goodsInfo = $request->param('goodsInfo');
        $link = $request->param('link');
        $imageList = $request->param('imageList');
        $forumId = $request->param('forumId');
        $result = $this->service->createPost($title,$content,$goodsInfo,$link,$imageList,$forumId);
        return $this->success($result);
    }

    public function getBuyJumpInfo(AuthedRequest $request)
    {
        $this->validate([
            'goodsSign' => 'string|required|min:1',
            'searchId' => 'string|min:1'
        ]);
        $goodsSign = $request->param('goodsSign');
        $searchId = $request->param('searchId');
        $result = $this->service->generateBuyInfo($goodsSign,$searchId);
        return $this->success($result);
    }
}