<?php


namespace App\Controller\Admin;
use App\Http\AppAdminRequest;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\GoodsCategoryService;
use ZYProSoft\Http\AuthedRequest;

/**
 * @AutoController (prefix="/admin/category")
 * Class GoodsCategoryController
 * @package App\Controller\Admin
 */
class GoodsCategoryController extends AbstractController
{
    /**
     * @Inject
     * @var GoodsCategoryService
     */
    protected GoodsCategoryService $service;

    public function create(AppAdminRequest $request)
    {
        $this->validate([
            'name' => 'string|required|min:1|max:50|sensitive',
            'image' => 'string|min:1|max:500',
            'shopId' => 'integer|min:1|exists:shop,shop_id'
        ]);
        $name = $request->param('name');
        $image = $request->param('image');
        $shopId = $request->param('shopId');
        $result = $this->service->userCreate($name, $shopId, $image);
        return $this->success($result);
    }

    public function update(AppAdminRequest $request)
    {
        $this->validate([
            'categoryId' => 'integer|required|exists:category,category_id',
            'name' => 'string|required|min:1|max:50|sensitive',
            'image' => 'string|min:1|max:500',
            'shopId' => 'integer|min:1|exists:shop,shop_id'
        ]);
        $name = $request->param('name');
        $image = $request->param('image');
        $shopId = $request->param('shopId');
        $categoryId = $request->param('categoryId');
        $result = $this->service->userUpdate($name, $categoryId, $shopId, $image);
        return $this->success($result);
    }

    public function delete(AppAdminRequest $request)
    {
        $this->validate([
            'categoryId' => 'integer|min:1|exists:category,category_id',
            'shopId' => 'integer|min:1|exists:shop,shop_id'
        ]);
        $categoryId = $request->param('categoryId');
        $shopId = $request->param('shopId');
        $result = $this->service->userDelete($categoryId,$shopId);
        return $this->success($result);
    }
}