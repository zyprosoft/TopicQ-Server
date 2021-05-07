<?php


namespace App\Controller\Admin;
use App\Http\AppAdminRequest;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\ShopService;

/**
 * @AutoController (prefix="/admin/shop")
 * Class ShopController
 * @package App\Controller\Admin
 */
class ShopController extends AbstractController
{
    /**
     * @Inject
     * @var ShopService
     */
    protected ShopService $service;

    public function create(AppAdminRequest $request)
    {
        $this->validate([
            'image' => 'string|min:1|max:500|required',
            'name' => 'string|min:1|max:50|required|sensitive',
            'address' => 'string|min:1|max:128|required',
            'introduce' => 'string|min:1|max:1000|sensitive',
            'phone' => 'string|min:1|max:20|required',
            'basePrice' => 'integer|min:10|max:1000000', //起送价最多不能超过1万
            'openTime' => 'integer|between:0,24',
            'closeTime' => 'integer|between:0,24|gt:openTime',
        ]);
        $result = $this->service->create($request->getParams());
        return $this->success($result);
    }

    public function update(AppAdminRequest $request)
    {
        $this->validate([
            'shopId' => 'required|integer|exists:shop,shop_id',
            'image' => 'string|min:1',
            'name' => 'string|min:1|max:50|sensitive',
            'address' => 'string|min:1|max:128',
            'introduce' => 'string|min:1|max:1000|sensitive',
            'basePrice' => 'integer|min:10|max:1000000', //起送价最多不能超过1万
            'openTime' => 'integer|between:0,24',
            'closeTime' => 'integer|between:0,24|gt:openTime',
            'phone' => 'string|min:1|max:20',
        ]);
        $shopId = $request->param('shopId');
        $result = $this->service->updateInfo($request->getParams(), $shopId);
        return $this->success($result);
    }

    public function changeStatus(AppAdminRequest $request)
    {
        $this->validate([
            'status' => 'required|integer|in:0,1',
            'shopId' => 'required|integer|exists:shop,shop_id',
        ]);
        $status = $request->param('status');
        $shopId = $request->param('shopId');
        $result = $this->service->changeStatus($status, $shopId);
        return $this->success($result);
    }

    public function changeRecommendStatus(AppAdminRequest $request)
    {
        $this->validate([
            'status' => 'required|integer|in:0,1',
        ]);
        $status = $request->param('status');
        $result = $this->service->changeShopRecommendStatus($status);
        return $this->success($result);
    }
}