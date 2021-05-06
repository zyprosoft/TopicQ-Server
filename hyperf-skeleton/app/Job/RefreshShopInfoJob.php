<?php


namespace App\Job;
use App\Constants\Constants;
use App\Model\Order;
use App\Model\Shop;
use App\Model\User;
use Hyperf\AsyncQueue\Job;
use Hyperf\DbConnection\Db;
use ZYProSoft\Log\Log;

class RefreshShopInfoJob extends Job
{
    private int $shopId;

    public function __construct(int $shopId)
    {
        $this->shopId = $shopId;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $shopId = $this->shopId;

        //异步统计该店铺的总用户数
        $shop = Shop::query()->where('shop_id',$shopId)
            ->first();
        if (!$shop instanceof Shop) {
            return;
        }

        //获取总共下单人数
        $orderCount = Order::query()->where('shop_id', $shopId)
            ->where('pay_status',Constants::STATUS_DONE)
            ->count();
        $shop->total_order = $orderCount;

        //获取最后五个订单的用户头像
        $orderList = Order::query()->select(['owner_id','order_id'])
            ->where('pay_status',Constants::STATUS_DONE)
            ->where('shop_id', $shopId)
            ->orderByDesc('order_id')
            ->limit(15)
            ->get();
        $userIds = $orderList->pluck('owner_id')->unique();
        $length = count($userIds)>5? 5:count($userIds);
        $avatarUserIds = $userIds->slice(0,$length);
        $avatarList = User::query()->select(['avatar'])
            ->whereIn('user_id', $avatarUserIds)
            ->get()
            ->pluck('avatar')
            ->implode(';');
        $shop->avatar_list = $avatarList;
        $shop->latest_order_list = $orderList->pluck('order_id')->implode(';');

        //总下单人数
        $userTotal = Order::query()->selectRaw('distinct owner_id')
            ->where('shop_id', $shopId)
            ->get()
            ->count();
        $shop->total_customer = $userTotal;

        //统计所有未送货订单的数量
        $total = Order::query()->where('shop_id', $shopId)
            ->where('pay_status',Constants::STATUS_DONE)
            ->where('deliver_status', Constants::STATUS_WAIT)
            ->where('finish_status',Constants::ORDER_STATUS_PROCESSING)
            ->count();
        $shop->wait_deliver_order_count = $total;

        $shop->save();
        Log::info("will async update shop info:".json_encode($shop));
        Log::info("async update shop($shopId) info finish!");
    }
}