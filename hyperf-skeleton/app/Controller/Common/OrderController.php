<?php


namespace App\Controller\Common;
use App\Http\AppAdminRequest;
use Qiniu\Auth;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\OrderService;
use ZYProSoft\Http\AuthedRequest;

/**
 * @AutoController (prefix="/common/order")
 * Class OrderController
 * @package App\Controller\Common
 */
class OrderController extends AbstractController
{
    /**
     * @Inject
     * @var OrderService
     */
    private OrderService $service;

    public function create(AuthedRequest $request)
    {
        $this->validate([
            'goodsList.*.goodsId' => 'required|integer|exists:goods,goods_id',
            'goodsList.*.count' => 'required|integer|min:1|max:999',
            'shopId' => 'required|integer|exists:shop,shop_id',
            'nickname' => 'required|string|min:1|max:20',
            'address' => 'required|string|min:1|max:128',
            'note' => 'string|min:1|max:128|sensitive',//这个信息会外显，需要过滤
            'mobile' => 'required|string|min:1|max:11',
            'deliverType' => 'required|integer|in:0,1',
            'hasSubscribe' => 'integer|in:0,1',//是不是包含虚拟商品，只有选了1才会校验用户是否已经订阅过
            'voucherSn' => 'string|exists:voucher,voucher_sn'
        ]);
        $result = $this->service->create($request->getParams());
        return $this->success($result);
    }

    public function payOrder(AuthedRequest $request)
    {
        $this->validate([
            'orderNo' => 'required|string|min:1|max:30|exists:order,order_no',
        ]);
        $orderNo = $request->param('orderNo');
        $result = $this->service->payOrder($orderNo);
        return $this->success($result);
    }

    public function updateReceiveStatus(AuthedRequest $request)
    {
        $this->validate([
            'orderNo' => 'required|string|min:1|max:30|exists:order,order_no',
        ]);
        $orderNo = $request->param('orderNo');
        $result = $this->service->updateReceiveFinishStatus($orderNo);
        return $this->success($result);
    }

    public function getUserNotPayOrderList(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'required|integer|min:0',
            'pageSize' => 'required|integer|min:1|max:30'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->getUserNotPayOrderList($pageIndex, $pageSize);
        return $this->success($result);
    }

    public function getUserOrderListByDeliverStatus(AuthedRequest $request)
    {
        $this->validate([
            'status' => 'required|integer|in:0,1',
            'pageIndex' => 'required|integer|min:0',
            'pageSize' => 'required|integer|min:0|max:30'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $status = $request->param('status');
        $result = $this->service->getUserOrderListByDeliverStatus($status, $pageIndex, $pageSize);
        return $this->success($result);
    }

    public function getUserFinishOrderList(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'required|integer|min:0',
            'pageSize' => 'required|integer|min:0|max:30'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->getUserFinishOrderList($pageIndex, $pageSize);
        return $this->success($result);
    }

    public function getUserOrderTotalInfo(AuthedRequest $request)
    {
        $result = $this->service->getUserOrderTotalInfo();
        return $this->success($result);
    }

    public function userAppreciate(AuthedRequest $request)
    {
        $this->validate([
            'orderNo' => 'required|string|min:1|max:30|exists:order,order_no',
        ]);
        $orderNo = $request->param('orderNo');
        $result = $this->service->userAppreciate($orderNo);
        return $this->success($result);
    }

    public function asyncCheckOrder(AuthedRequest $request)
    {
        $this->validate([
            'orderNo' => 'required|string|min:1|max:30|exists:order,order_no',
        ]);
        $orderNo = $request->param('orderNo');
        $result = $this->service->asyncCheckOrderStatus($orderNo);
        return $this->success($result);
    }

    /**
     * 与列表返回不一致的时候主动刷新统计数据
     * @param AuthedRequest $request
     */
    public function refreshUserOrderSummary(AuthedRequest $request)
    {
        $result = $this->service->refreshUserOrderSummary();
        return $this->success($result);
    }

    public function addOrderMessage(AuthedRequest $request)
    {
        $this->validate([
            'orderNo' => 'required|string|min:1|max:30|exists:order,order_no',
            'content' => 'required|string|min:1|max:128|sensitive'
        ]);
        $orderNo = $request->param('orderNo');
        $content = $request->param('content');
        $result = $this->service->addOrderMessage($orderNo,$content);
        return $this->success($result);
    }

    public function addOrderComment(AuthedRequest $request)
    {
        $this->validate([
            'orderNo' => 'required|string|min:1|max:30|exists:order,order_no',
            'content' => 'required|string|min:1|max:128|sensitive'
        ]);
        $orderNo = $request->param('orderNo');
        $content = $request->param('content');
        $result = $this->service->addOrderComment($orderNo,$content);
        return $this->success($result);
    }

    public function closeOrder(AuthedRequest $request)
    {
        $this->validate([
            'orderNo' => 'required|string|min:1|max:30|exists:order,order_no',
        ]);
        $orderNo = $request->param('orderNo');
        $result = $this->service->closeOrder($orderNo);
        return $this->success($result);
    }
}