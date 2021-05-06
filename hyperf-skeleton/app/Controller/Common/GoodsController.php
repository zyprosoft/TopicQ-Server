<?php


namespace App\Controller\Common;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\GoodsService;
use ZYProSoft\Http\AuthedRequest;

/**
 * @AutoController (prefix="/common/goods")
 * Class GoodsController
 * @package App\Controller\Common
 */
class GoodsController extends AbstractController
{
    /**
     * @Inject
     * @var GoodsService
     */
    protected GoodsService $service;

    public function getGoodsListByShopId()
    {
        $this->validate([
            'shopId' => 'integer|required|exists:shop,shop_id',
        ]);
        $shopId = $this->request->param('shopId');
        $result = $this->service->getGoodsListByShopId($shopId);
        return $this->success($result);
    }

    public function getGoodsListByCategoryId()
    {
        $this->validate([
            'shopId' => 'integer|required|exists:shop,shop_id',
            'categoryId' => 'integer|required|exists:goods_category,category_id'
        ]);
        $shopId = $this->request->param('shopId');
        $categoryId = $this->request->param('categoryId');
        $result = $this->service->getGoodsListByCategoryId($categoryId, $shopId);
        return $this->success($result);
    }
}