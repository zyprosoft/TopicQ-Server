<?php


namespace App\Service;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Model\Good;
use App\Model\Order;
use App\Model\Voucher;
use App\Model\VoucherPolicy;
use App\Model\VoucherUseHistory;
use Carbon\Carbon;
use Hyperf\DbConnection\Db;
use phpDocumentor\Reflection\Types\Collection;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Log\Log;

class VoucherService extends BaseService
{
    protected function generateVoucherSn(string $prefix)
    {
        $datetime = date('YmdHis');
        $now = Carbon::now();
        $microsecond = $now->microsecond;
        return $prefix.$datetime.$microsecond;
    }

    /**
     * 用户领券
     * @param integer $policyId
     */
    public function createVoucher(int $policyId)
    {
        Db::transaction(function () use ($policyId) {

            //批次检查
            $policy = VoucherPolicy::query()->where('policy_id',$policyId)->lockForUpdate()->first();
            if (!$policy instanceof VoucherPolicy) {
                throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
            }
            if ($policy->left_count < 1) {
                throw new HyperfCommonException(ErrorCode::VOUCHER_CREATE_POLICY_COUNT_ERROR);
            }

            //用户是不是领过这个批次的券，一个批次只能领一次
            $voucher = Voucher::query()->where('policy_id', $policyId)
                ->where('owner_id',$this->userId())
                ->first();
            if ($voucher instanceof Voucher) {
                throw new HyperfCommonException(ErrorCode::VOUCHER_CREATE_REPEAT);
            }
            $voucher = new Voucher();
            $voucher->policy_id = $policyId;
            $voucher->owner_id = $this->userId();
            $voucher->left_amount = $policy->amount;
            $voucher->voucher_sn = $this->generateVoucherSn($policy->sn_prefix);
            //计算生效和过期时间
            if (!empty($policy->time_span) && !empty($policy->time_unit)) {
                $voucher->begin_time = Carbon::now()->toDateTimeString();
                switch ($policy->time_unit) {
                    case Constants::VOUCHER_TIME_UNIT_MINUTE:
                        $endTime = Carbon::now()->addRealMinutes($policy->time_span);
                        break;
                    case Constants::VOUCHER_TIME_UNIT_HOUR:
                        $endTime = Carbon::now()->addRealHours($policy->time_span);
                        break;
                    case Constants::VOUCHER_TIME_UNIT_DAY:
                        $endTime = Carbon::now()->addRealDays($policy->time_span);
                        break;
                    case Constants::VOUCHER_TIME_UNIT_MONTH:
                        $endTime = Carbon::now()->addRealMonths($policy->time_span);
                        break;
                    case Constants::VOUCHER_TIME_UNIT_YEAR:
                        $endTime = Carbon::now()->addRealYears($policy->time_span);
                        break;
                    default:
                        $endTime = Carbon::now()->addRealMinutes(1)->toDateString();
                        break;
                }
                //结束都按照天来算,不足一天算一天
                $voucher->end_time = $endTime->toDateString();
            }
            $voucher->saveOrFail();
            //批次减少一张券
            $policy->decrement('left_count');
        });
        return $this->success();
    }

    public function getMyVoucherList(int $pageIndex, int $pageSize, int $status)
    {
        $operate = '=';
        if ($status == Constants::STATUS_NOT) {
            $operate = '<>';
        }

        $list = Voucher::query()->where('owner_id',$this->userId())
            ->where('status',$operate,Constants::STATUS_DONE)
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->latest()
            ->get();
        $total = Voucher::query()->where('owner_id',$this->userId())
            ->where('status',$operate,Constants::STATUS_DONE)
            ->count();
        return ['total'=>$total,'list'=>$list];
    }

    public function checkVoucherMathGoods(Good $goods, Voucher $voucher)
    {
        $acceptCategoryIds = collect();
        $acceptGoodsIds = collect();
        if (!empty($voucher->policy->goods->category_list)) {
            $acceptCategoryIds = explode(',',$voucher->policy->goods->category_list);
            $acceptCategoryIds = collect($acceptCategoryIds);
        }
        if (!empty($voucher->policy->goods->goods_list)) {
            $acceptGoodsIds = explode(',',$voucher->policy->goods->goods_list);
            $acceptGoodsIds = collect($acceptGoodsIds);
        }

        $blackCategoryIds = collect();
        $blackGoodsIds = collect();
        if (!empty($voucher->policy->black_goods->category_list)) {
            $blackCategoryIds = explode(',',$voucher->policy->black_goods->category_list);
            $blackCategoryIds = collect($blackCategoryIds);
        }
        if (!empty($voucher->policy->black_goods->goods_list)) {
            $blackGoodsIds = explode(',',$voucher->policy->black_goods->goods_list);
            $blackGoodsIds = collect($blackGoodsIds);
        }

        //如果两个都为空，说明是无条件券，这个时候直接看黑名单即可
        if ($acceptCategoryIds->isEmpty() && $acceptGoodsIds->isEmpty()) {
            //如果黑名单也不存在，直接放过
            if ($blackCategoryIds->isEmpty() && $blackGoodsIds->isEmpty()) {
                Log::info("($voucher->voucher_sn)这张券无任何限制，可匹配所有商品");
                return true;
            }
            //在分类上面直接拉黑了
            if ($blackCategoryIds->isNotEmpty() && $blackGoodsIds->isEmpty()) {
                return $blackCategoryIds->contains($goods->category_id) ? false:true;
            }
            //在商品ID上被拉黑了
            if ($blackGoodsIds->isNotEmpty()) {
                return $blackGoodsIds->contains($goods->goods_id) ? false:true;
            }
        }

        //先匹配白名单，能匹配上就是可使用的,不能匹配则不看黑名单
        //是不是分类下的通用券,是的只匹配分类是否一致即可
        if ($acceptCategoryIds->isNotEmpty() && $acceptGoodsIds->isEmpty()) {
            return $acceptCategoryIds->contains($goods->category_id);
        }
        //如果是指定了商品,忽略一层是否匹配
        if ($acceptGoodsIds->isNotEmpty()) {
            return $acceptGoodsIds->contains($goods->goods_id);
        }

        return false;
    }

    public function checkOrderMatchVoucherCashInfo(array $orderGoods, Voucher $voucher, $goodsList = null)
    {
        if (empty($orderGoods)) {
            return false;
        }
        //
        $deductAmount = 0;
        $orderGoods = collect($orderGoods);
        $goodsIds = $orderGoods->pluck('goodsId');
        if (!isset($goodsList)) {
            $goodsList = Good::findMany($goodsIds)->keyBy('goods_id');
        }
        $initVoucherAmount = $voucher->left_amount;
        $orderGoods->map(function ($goods) use (&$deductAmount, &$initVoucherAmount, $goodsList , $voucher) {
            $goodsId = $goods['goodsId'];
            $count = $goods['count'];
            //券是否匹配
            $dbGoods = $goodsList->get($goodsId);
            $isMatch = $this->checkVoucherMathGoods($dbGoods, $voucher);
            if ($isMatch && $initVoucherAmount > 0) {
                $goodsCash = $dbGoods->price * $count;
                if($initVoucherAmount <= $goodsCash) {
                    $deductAmount += $initVoucherAmount;
                    $initVoucherAmount = 0;
                }else{
                    $deductAmount += $goodsCash;
                    $initVoucherAmount -= $goodsCash;
                }
            }
        });
        //返回最终可以抵扣的金额
        $goodsIdsString = $goodsIds->toJson();
        Log::info("计算出券($voucher->voucher_sn)和商品列表($goodsIdsString)最终可抵扣金额为:($deductAmount)分");
        return [
            'deduct' => $deductAmount,
            'voucherLeftAmount' => $initVoucherAmount,
            'voucher' => $voucher
        ];
    }

    public function getMyVoucherUseHistoryList(int $pageIndex, int $pageSize)
    {
        $list = VoucherUseHistory::query()->where('owner_id',$this->userId())
                                          ->offset($pageIndex * $pageSize)
                                          ->limit($pageSize)
                                          ->get();

        $total = VoucherUseHistory::query()->where('owner_id',$this->userId())->count();

        return ['total'=>$total,'list'=>$list];
    }

    protected function innerRollbackVoucher(Order $order)
    {
        //查找订单使用记录
        $voucherUseHistory = VoucherUseHistory::query()->where('voucher_id',$order->voucher_id)
            ->where('order_id',$order->order_id)
            ->where('status',Constants::VOUCHER_USE_HISTORY_STATUS_NORMAL)
            ->lockForUpdate()
            ->first();
        if (!$voucherUseHistory instanceof VoucherUseHistory) {
            Log::info("{$order->order_no}订单没有找到扣券记录");
            return;
        }
        $voucher = Voucher::query()->where('voucher_id',$order->voucher_id)->lockForUpdate()->first();
        if (!$voucher instanceof Voucher) {
            Log::info("{$order->order_no}订单使用代金券不存在!");
            return;
        }
        $voucher->left_amount += $voucherUseHistory->amount;
        $voucher->saveOrFail();
        //更新使用记录状态
        $voucherUseHistory->status = Constants::VOUCHER_USE_HISTORY_STATUS_ROLLBACK;
        $voucherUseHistory->rollback_time = Carbon::now()->toDateTimeString();
        $voucherUseHistory->saveOrFail();
        Log::info("订单{$order->order_no}所使用的代金券金额({$voucherUseHistory->amount})已回滚");
    }

    public function rollbackVoucher(string $orderNo,bool $needTrans = true)
    {
        //回滚订单使用的代金券
        $order = Order::query()->where('order_no',$orderNo)->first();
        if (!$order instanceof Order) {
            Log::info("{$orderNo}订单未找到!");
            return;
        }
        if (!isset($order->voucher)) {
            Log::info("{$orderNo}订单没有使用代金券!");
            return;
        }
        if ($needTrans) {
            //开始回滚
            Db::transaction(function () use ($order){
                $this->innerRollbackVoucher($order);
            });
        }else{
            $this->innerRollbackVoucher($order);
        }
    }

    //查询订单商品可使用的代金券列表
    public function getVoucherListByGoodsIds(array $orderGoods)
    {
        //获取所有待使用的券
        $voucherList = Voucher::query()->where('status',Constants::STATUS_WAIT)
                                       ->where('owner_id', $this->userId())
                                       ->get();
        //检查券和商品列表是否匹配
        $goodsIds = collect($orderGoods)->pluck('goodsId');
        $goodsList = Good::findMany($goodsIds)->keyBy('goods_id');
        $matchedList = collect();
        $voucherList->map(function (Voucher $voucher) use ($orderGoods,$goodsList,&$matchedList){
            $deductInfo = $this->checkOrderMatchVoucherCashInfo($orderGoods,$voucher,$goodsList);
            if ($deductInfo !== false && $deductInfo['deduct'] > 0) {
                $voucher->deduct = $deductInfo['deduct'];
                $matchedList->push($voucher);
            }
        });
        //进行排序,可抵扣金额大的靠前,到期时间最快的靠前
        $sortList = $matchedList->sortByDesc('deduct')->sortBy('end_time')->values()->all();
        return $this->success($sortList);
    }

    public function getDisplayName($goodsOrBlackGoods,$isBlack)
    {
        $categoryItems = $goodsOrBlackGoods->category_items();
        $goodsItems = $goodsOrBlackGoods->goods_items();
        if($goodsItems->isNotEmpty()) {
            $names = $goodsItems->pluck('name')->toArray();
            return implode(';',$names);
        }else{
            if ($categoryItems->isNotEmpty()) {
                $names = $categoryItems->pluck('name')->toArray();
                return  implode(';',$names);
            }
            return $isBlack? '无黑名单产品限制':'适用产品无限制';
        }
    }
}