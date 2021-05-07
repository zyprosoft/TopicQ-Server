<?php


namespace App\Service\Admin;
use App\Constants\Constants;
use App\Job\RefreshShopInfoJob;
use App\Job\RefreshShopOrderSummaryJob;
use App\Job\RefreshUserOrderSummaryJob;
use App\Job\SendUserOrderStatusChangeMessageJob;
use App\Model\Order;
use App\Model\ShopOrderSummary;
use App\Service\BaseService;
use Carbon\Carbon;
use Hyperf\DbConnection\Db;
use ZYProSoft\Log\Log;

class OrderService extends BaseService
{
    /**
     * 获取店铺某个状态的订单汇总
     * @param int $status
     * @param int $shopId
     */
    public function getShopOrderSummary(int $shopId)
    {
        //检查用户权限
        ShopService::checkOwnOrFail($shopId);
        $list = ShopOrderSummary::query()->where('shop_id', $shopId)
            ->orderBy('type')
            ->get();
        $list->map(function (ShopOrderSummary $summary){
            $summary->summary_info = json_decode($summary->summary_info);
            return $summary;
        });
        Log::info('shop order summary new:'.json_encode($list));
        return $list;
    }

    public function getShopProcessingOrderListByDeliveryStatus(int $status, int $shopId, int $pageIndex, int $pageSize = 30)
    {
        //检查用户权限
        ShopService::checkOwnOrFail($shopId);
        $list = Order::query()->where('shop_id', $shopId)
            ->where('pay_status',Constants::STATUS_DONE)
            ->where('deliver_status', $status)
            ->where('finish_status', Constants::ORDER_STATUS_PROCESSING)
            ->with(['order_goods','owner'])
            ->when($status == Constants::STATUS_DONE , function ($query) {
                $query->orderByDesc('deliver_time');
            })
            ->when($status == Constants::STATUS_WAIT , function ($query) {
                $query->orderByDesc('order_id');
            })
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();
        $total = Order::query()->where('shop_id', $shopId)
            ->where('pay_status',Constants::STATUS_DONE)
            ->where('deliver_status', $status)
            ->where('finish_status', Constants::ORDER_STATUS_PROCESSING)
            ->count();
        return [
            'total' => $total,
            'list' => $list
        ];
    }

    /**
     * 获取店铺已经完成的订单
     * @param int $shopId
     * @param int $pageIndex
     * @param $pageSize
     * @return \Hyperf\Database\Model\Builder[]|\Hyperf\Database\Model\Collection
     */
    public function getShopFinishOrderList(int $shopId, int $pageIndex, int $pageSize = 30)
    {
        //检查用户权限
        ShopService::checkOwnOrFail($shopId);
        $list = Order::query()->where('shop_id', $shopId)
            ->where('pay_status', Constants::STATUS_DONE)
            ->where('finish_status', Constants::STATUS_DONE)
            ->with(['order_goods','owner'])
            ->orderByDesc('receive_time')
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();
        $total = Order::query()->where('shop_id', $shopId)
            ->where('finish_status', Constants::STATUS_DONE)->count();
        return [
            'total' => $total,
            'list' => $list
        ];
    }

    /**
     * 获取店铺所有订单信息
     * @param int $shopId
     * @param int $pageIndex
     * @param $pageSize
     */
    public function getShopOrderList(int $shopId, int $pageIndex, int $pageSize = 30)
    {
        $list = Order::query()->where('shop_id', $shopId)
            ->where('pay_status',Constants::STATUS_DONE)
            ->with(['order_goods','owner'])
            ->orderByDesc('order_id')
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();
        $total = Order::query()->where('shop_id', $shopId)
            ->where('pay_status',Constants::STATUS_DONE)
            ->count();
        return [
            'total' => $total,
            'list' => $list
        ];
    }

    /**
     * 更新送货状态
     * @param string $orderNo
     * @param int $status
     * @return Order|\Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model
     * @throws \Throwable
     */
    public function updateDeliverStatus(string $orderNo, int $status)
    {
        $order = null;
        Db::transaction(function () use ($orderNo, $status, &$order) {
            $order = \App\Service\OrderService::checkOwnOrFail($orderNo, true, true);
            if ($order->deliver_status == $status) {
                Log::info("orderNo($orderNo) update deliver status is the same!");
                return $order;
            }
            $order->deliver_status = $status;
            $order->deliver_time = Carbon::now()->toDateTimeString();
            $order->saveOrFail();
        });

        //确认发货成功，异步刷新店铺信息
        $this->push(new RefreshShopInfoJob($order->shop_id));

        //异步刷新店铺订单统计信息
        $this->push(new RefreshShopOrderSummaryJob($order->shop_id));

        //异步刷新用户订单统计信息
        $this->push(new RefreshUserOrderSummaryJob($order->owner_id));

        //发送订单状态变化通知
        $this->push(new SendUserOrderStatusChangeMessageJob($order->order_no));

        return $order;
    }

    public function refreshShopOrderSummary(int $shopId)
    {
        $this->push(new RefreshShopOrderSummaryJob($shopId));
        return $this->success();
    }
}