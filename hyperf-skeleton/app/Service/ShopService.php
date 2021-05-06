<?php


namespace App\Service;


use App\Model\Order;
use App\Model\Shop;
use ZYProSoft\Log\Log;

class ShopService extends BaseService
{
    public function info(int $shopId)
    {
        $shop = Shop::query()->where('shop_id', $shopId)
            ->with(['owner'])
            ->firstOrFail();
        if (!$shop instanceof Shop) {
            Log::info('find shop fail!');
        }

        //获取店铺最晚的订单的信息返回
        if(!empty($shop->latest_order_list)) {
            $orderIds = explode(';', $shop->latest_order_list);
            if (!empty($orderIds)) {
                $orderList = Order::query()->whereIn('order_id', $orderIds)
                    ->with(['owner','order_goods'])
                    ->latest()
                    ->get();
                $shop->latest_order_list = $orderList;
            }
        }

        //转化成数组返回
        if (!empty($shop->avatar_list)) {
            $shop->avatar_list = explode(';',$shop->avatar_list);
        }

        return $shop;
    }
}