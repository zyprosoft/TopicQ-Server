<?php


namespace App\Job;
use App\Constants\Constants;
use App\Model\Order;
use App\Model\OrderSummary;
use App\Model\ShopOrderSummary;
use Hyperf\AsyncQueue\Job;
use Hyperf\DbConnection\Db;
use Hyperf\Utils\Collection;
use ZYProSoft\Facade\Cache;
use ZYProSoft\Log\Log;

class RefreshShopOrderSummaryJob extends Job
{
    private string $cacheKey;

    /**
     * 待刷新的店铺
     * @var int
     */
    private int $shopId;

    public function __construct(int $shopId,string $cacheKey)
    {
        $this->shopId = $shopId;
        $this->cacheKey = $cacheKey;
    }

    protected function getSummaryInfoByOrderList(Collection $list)
    {
        if ($list->isEmpty()) {
            return [
                'goods_list' => [],
                'total' => 0
            ];
        }
        $summary = [];
        $list->map(function (Order $order) use (&$summary) {
            $orderGoodsList = collect($order->order_goods)->keyBy('goods_id');
            foreach ($orderGoodsList as $goodsId => $orderGood) {
                if (!isset($summary['goods_list'][$goodsId])) {
                    $summary['goods_list'][$goodsId]['goods_name'] = $orderGood->order_goods_name;
                    $summary['goods_list'][$goodsId]['count'] = 0;
                    $summary['goods_list'][$goodsId]['unit'] = $orderGood->order_unit;
                }
                $summary['goods_list'][$goodsId]['count'] += $orderGood->count;
            }
        });
        if (isset($summary['goods_list'])  && !empty($summary['goods_list'])) {
            $summary['goods_list'] = array_values($summary['goods_list']);
        }else{
            $summary['goods_list'] = [];
        }
        $summary['total'] = count($summary['goods_list']);
        return $summary;
    }

    /**
     * 获取店铺某个发货状态的订单汇总
     * @param int $status
     * @param int $shopId
     */
    protected function getOrderSummaryByDeliveryStatus(int $status, int $shopId)
    {
        $list = Order::query()->where('shop_id', $shopId)
            ->where('pay_status',Constants::STATUS_DONE)
            ->where('deliver_status', $status)
            ->where('finish_status', Constants::ORDER_STATUS_PROCESSING)
            ->with(['order_goods'])
            ->get();
        return $this->getSummaryInfoByOrderList($list);
    }

    protected function saveSummary(int $type, array $info, int $orderTotal)
    {
        $summary = ShopOrderSummary::query()->where('shop_id', $this->shopId)
            ->where('type',$type)
            ->first();
        if(!$summary instanceof ShopOrderSummary) {
            $summary = new ShopOrderSummary();
            $summary->type = $type;
            $summary->shop_id = $this->shopId;
        }
        $summary->summary_info = json_encode($info);
        $summary->order_total = $orderTotal;
        $summary->save();
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        Cache::delete($this->cacheKey);

        //获取发货中的
        $waitOrderSummary = $this->getOrderSummaryByDeliveryStatus(Constants::STATUS_WAIT, $this->shopId);
        //更新订单数量
        $waitDeliverCount = Order::query()->where('shop_id', $this->shopId)
            ->where('pay_status',Constants::STATUS_DONE)
            ->where('deliver_status', Constants::STATUS_WAIT)
            ->where('finish_status', Constants::ORDER_STATUS_PROCESSING)
            ->count();
        $this->saveSummary(Constants::ORDER_SUMMARY_WAIT_DELIVER, $waitOrderSummary, $waitDeliverCount);

        //已发货
        $deliveredInfo = $this->getOrderSummaryByDeliveryStatus(Constants::STATUS_DONE, $this->shopId);
        $finishDeliverCount = Order::query()->where('shop_id', $this->shopId)
            ->where('pay_status',Constants::STATUS_DONE)
            ->where('deliver_status', Constants::STATUS_DONE)
            ->where('finish_status', Constants::ORDER_STATUS_PROCESSING)
            ->count();
        $this->saveSummary(Constants::ORDER_SUMMARY_DELIVERED, $deliveredInfo, $finishDeliverCount);

        //已完成
        $list = Order::query()->where('shop_id', $this->shopId)
            ->where('pay_status',Constants::STATUS_DONE)
            ->where('finish_status', Constants::STATUS_DONE)
            ->with(['order_goods'])
            ->get();
        $finishInfo = $this->getSummaryInfoByOrderList($list);
        $finishCount = Order::query()->where('shop_id', $this->shopId)
            ->where('pay_status',Constants::STATUS_DONE)
            ->where('finish_status', Constants::STATUS_DONE)
            ->count();
        $this->saveSummary(Constants::ORDER_SUMMARY_FINISH, $finishInfo, $finishCount);

        Log::info("shopId({$this->shopId}) async save summary info success!");
    }
}