<?php


namespace App\Controller\Admin;
use App\Http\AppAdminRequest;
use App\Service\Admin\OrderService;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;

/**
 * @AutoController (prefix="/admin/order")
 * Class OrderController
 * @package App\Controller\Admin
 */
class OrderController extends AbstractController
{
    /**
     * @Inject
     * @var OrderService
     */
    protected OrderService $service;

    public function updateDeliverStatus(AppAdminRequest $request)
    {
        $this->validate([
            'orderNo' => 'required|string|min:1|max:30|exists:order,order_no',
            'status' => 'required|integer|in:0,1'
        ]);
        $orderNo = $request->param('orderNo');
        $status = $request->param('status');
        $result = $this->service->updateDeliverStatus($orderNo, $status);
        return $this->success($result);
    }

    public function getShopOrderSummary(AppAdminRequest $request)
    {
        $this->validate([
            'shopId' => 'required|integer|exists:shop,shop_id',
        ]);
        $shopId = $request->param('shopId');
        $result = $this->service->getShopOrderSummary($shopId);
        return $this->success($result);
    }

    public function getShopOrderListByDeliverStatus(AppAdminRequest $request)
    {
        $this->validate([
            'shopId' => 'required|integer|exists:shop,shop_id',
            'status' => 'required|integer|in:0,1',
            'pageIndex' => 'required|integer|min:0',
            'pageSize' => 'required|integer|min:1|max:30'
        ]);
        $shopId = $request->param('shopId');
        $status = $request->param('status');
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->getShopProcessingOrderListByDeliveryStatus($status, $shopId, $pageIndex, $pageSize);
        return $this->success($result);
    }

    public function getShopFinishOrderList(AppAdminRequest $request)
    {
        $this->validate([
            'shopId' => 'required|integer|exists:shop,shop_id',
            'pageIndex' => 'required|integer|min:0',
            'pageSize' => 'required|integer|min:0|max:30'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $shopId = $request->param('shopId');
        $result = $this->service->getShopFinishOrderList($shopId, $pageIndex, $pageSize);
        return $this->success($result);
    }

    public function getShopOrderList(AppAdminRequest $request)
    {
        $this->validate([
            'shopId' => 'required|integer|exists:shop,shop_id',
            'pageIndex' => 'required|integer|min:0',
            'pageSize' => 'required|integer|min:0|max:30'
        ]);
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $shopId = $this->request->param('shopId');
        $result = $this->service->getShopOrderList($shopId, $pageIndex, $pageSize);
        return $this->success($result);
    }
}