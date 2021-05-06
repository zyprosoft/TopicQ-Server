<?php


namespace App\Controller\Admin;
use App\Http\AppAdminRequest;
use App\Model\Unit;
use Hyperf\Validation\Rule;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\GoodsService;
use ZYProSoft\Http\AuthedRequest;

/**
 * @AutoController (prefix="/admin/goods")
 * Class GoodsController
 * @package App\Controller\Admin
 */
class GoodsController extends AbstractController
{
    /**
     * @Inject
     * @var GoodsService
     */
    protected GoodsService $service;

    public function create(AppAdminRequest $request)
    {
        $this->validate([
            'unit' => [
                'required',
                Rule::in(Unit::all()->pluck('name'))
            ],
            'categoryId' => 'integer|required|exists:goods_category,category_id',
            'name' => 'string|required|min:1|max:12|sensitive',
            'image' => 'string|required|min:1|max:500',
            'shopId' => 'integer|required|exists:shop,shop_id',
            'price' => 'integer|required|min:1',
            'stock' => 'integer|required|min:1|max:9999',
            'desc' => 'string|required|min:1|max:1000'
        ]);
        $result = $this->service->create($request->getParams());
        return $this->success($result);
    }

    public function update(AppAdminRequest $request)
    {
        $this->validate([
            'unit' => [
                Rule::in(Unit::all()->pluck('name'))
            ],
            'goodsId' => 'integer|required|exists:goods,goods_id',
            'name' => 'string|min:1|max:12|sensitive',
            'image' => 'string|min:1|max:500',
            'price' => 'integer|min:1',
            'stock' => 'integer|min:1|max:9999',
            'desc' => 'string|min:1|max:1000'
        ]);
        $result = $this->service->updateInfo($request->getParams());
        return $this->success($result);
    }

    public function delete(AppAdminRequest $request)
    {
        $this->validate([
            'goodsId' => 'integer|required|exists:goods,goods_id',
        ]);
        $goodsId = $request->param('goodsId');
        $result = $this->service->delete($goodsId);
        return $this->success($result);
    }

    public function allUnit(AppAdminRequest $request)
    {
        $result = $this->service->allUnit();
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
}