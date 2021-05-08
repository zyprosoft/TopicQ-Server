<?php


namespace App\Service;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Job\AddShopNotificationJob;
use App\Job\RefreshOrderPayStatusJob;
use App\Job\RefreshShopOrderSummaryJob;
use App\Job\RefreshUserOrderSummaryJob;
use App\Model\Good;
use App\Model\Order;
use App\Model\OrderGood;
use App\Model\Shop;
use App\Model\User;
use App\Model\UserOrderSummary;
use App\Model\UserSubscribe;
use Carbon\Carbon;
use Hyperf\DbConnection\Db;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Facade\Auth;
use ZYProSoft\Log\Log;
use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\ShopService;
use const Zipkin\Tags\ERROR;

class OrderService extends BaseService
{
    const ORDER_EXPIRE_TIME = 10;

    /**
     * @Inject
     * @var WxPayService
     */
    protected WxPayService $payService;

    /**
     * 生成订单号
     */
    protected function generateOrderNo()
    {
        $datetime = date('YmdHis');
        $now = Carbon::now();
        $microsecond = $now->microsecond;
        $random = rand(10000,99999);
        return $datetime . '-' . $microsecond . '-' . $random;
    }

    /**
     * 检查订单号是否属于当前用户，判定是否有操作权限
     * @param string $orderNo
     * @param bool $isShopOwn
     * @param bool $isLock
     * @return Order|\Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model
     */
    public static function checkOwnOrFail(string $orderNo, bool $isShopOwn = false, bool $isLock = false)
    {
        $order = Order::query()->where('order_no', $orderNo)->when($isLock, function ($query) {
            $query->lockForUpdate();
        })->first();
        if (!$order instanceof Order) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }
        if (Auth::isAdmin()) {
            return $order;
        }
        if ($isShopOwn ) {
            if($order->shop_owner_id != Auth::userId()) {
                Log::error("shopOwnerId:{$order->shop_owner_id} diff:".Auth::userId());
                throw new HyperfCommonException(ErrorCode::STAFF_NOT_BELONG_CURRENT_USER);
            }
        }else{
            if ($order->owner_id != Auth::userId()) {
                throw new HyperfCommonException(ErrorCode::STAFF_NOT_BELONG_CURRENT_USER);
            }
        }

        return $order;
    }

    public function create(array $params)
    {
        //用户是不是已经被拉黑
        $owner = UserService::checkUserStatusOrFail();

        //店铺是不是已经处于停止发布状态
        $shop = ShopService::checkShopPublishOrFail($params['shopId']);

        //用户是不是买的虚拟订阅产品，并且已经订购过了
        if (isset($params['hasSubscribe']) && $params['hasSubscribe'] == 1) {
            $goodsList = collect($params['goodsList']);
            $goodsIds = $goodsList->pluck('goodsId');
            $existGoodsList = Good::findMany($goodsIds);
            $existGoodsList->map(function (Good $good) {
                if($good->bind_forum_id > 0) {
                    //检查用户是否已经订阅过了
                    $subscribe = UserSubscribe::query()->where('user_id',$this->userId())
                        ->where('forum_id',$good->bind_forum_id)
                        ->first();
                    if ($subscribe instanceof UserSubscribe) {
                        throw new HyperfCommonException(ErrorCode::BUY_FORUM_NOT_NEED);
                    }
                }
            });
        }

        $order = null;
        Db::transaction(function () use ($params, &$order) {

            //先保存订单的商品信息
            $orderCash = 0;
            $goodsList = collect($params['goodsList']);
            $orderNo = $this->generateOrderNo();
            $goodsList->map(function ($goods) use ($orderNo, &$orderCash) {
                $orderGoods = new OrderGood();
                $goodsId = $goods['goodsId'];
                //商品库存是否足够,悲观锁防止篡改
                $existGoods = Good::query()->where('goods_id', $goodsId)->lockForUpdate()->first();
                if (!$existGoods instanceof Good) {
                    throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
                }
                if ($existGoods->stock < $goods['count']) {
                    throw new HyperfCommonException(ErrorCode::ORDER_GOODS_COUNT_OVER_STOCK);
                }
                $orderGoods->count = $goods['count'];
                $orderGoods->order_price = $existGoods->price;
                $orderGoods->order_unit = $existGoods->unit;
                $orderGoods->order_no = $orderNo;
                $orderGoods->goods_id = $goodsId;
                $orderGoods->order_goods_name = $existGoods->name;
                $orderGoods->order_goods_image = $existGoods->image;
                $existGoods->stock = $existGoods->stock - $goods['count'];
                $orderCash += $existGoods->price * $goods['count'];
                $orderGoods->saveOrFail();
                $existGoods->saveOrFail();
            });

            //创建订单
            $order = new Order();
            $order->order_no = $orderNo;
            $order->shop_id = $params['shopId'];
            $order->nickname = $params['nickname'];
            $order->address = $params['address'];
            $order->mobile = $params['mobile'];
            $order->customer_note = $params['note'];
            $order->deliver_type = $params['deliverType'];
            $order->cash = $orderCash;
            $order->owner_id = $this->userId();
            $shop = Shop::findOrFail($order->shop_id);
            $order->shop_owner_id = $shop->owner_id;

            //获取过期时间
            $expireTime = self::ORDER_EXPIRE_TIME;
            $orderExpireTime = Carbon::now()->addRealMinutes($expireTime)->toDateTimeString();
            $order->pay_expire_time = $orderExpireTime;

            $order->saveOrFail();

        });

        if (!isset($order)) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }

        //生成支付订单的签名信息
        $signInfo = $this->payService->genOrderSignInfo($order, $owner, $shop);
        $signInfo['orderNo'] = $order->order_no;

        //异步刷新用户订单统计信息
        $this->push(new RefreshUserOrderSummaryJob($this->userId()));

        return $signInfo;
    }

    public function asyncCheckOrderStatus(string $orderNo)
    {
        $this->push(new RefreshOrderPayStatusJob($orderNo));
        return $this->success();
    }

    /**
     * 待支付订单再次发起支付
     * @param string $orderNo
     */
    public function payOrder(string $orderNo)
    {
        $order = self::checkOwnOrFail($orderNo);
        //生成的prepayId是否超过1个半小时，如果超过了，需要重新生成
        $isNeedRefreshPrepayId = true;
        if(isset($order->wx_prepay_id_time)) {
            $minuteAgo = Carbon::now()->diffInRealMinutes($order->wx_prepay_id_time);
            if ($minuteAgo < 90) {
                $isNeedRefreshPrepayId = false;
            }
        }
        if ($isNeedRefreshPrepayId) {
            Log::info("prepayId 已经失效，需要重新进行统一下单");
            $user = User::findOrFail($order->owner_id);
            $shop = Shop::findOrFail($order->shop_id);
            return $this->payService->genOrderSignInfo($order, $user, $shop);
        }
        Log::info('prepayId 还有效，直接签名返回!');
        return  $this->payService->getPrepaySignInfo($order->wx_prepay_id);
    }

    /**
     * 更新收货状态
     * @param string $orderNo
     * @param int $status
     * @return Order|\Hyperf\Database\Model\Builder|\Hyperf\Database\Model\Model
     * @throws \Throwable
     */
    public function updateReceiveFinishStatus(string $orderNo)
    {
        $order = null;
        Db::transaction(function () use ($orderNo, &$order) {
            $order = OrderService::checkOwnOrFail($orderNo);
            if ($order->receive_status == Constants::STATUS_DONE) {
                Log::info("orderNo($orderNo) did finish receive!");
                return;
            }
            $order->receive_status = Constants::STATUS_DONE;
            $order->receive_time = Carbon::now()->toDateTimeString();
            $order->finish_status = Constants::STATUS_DONE;
            $order->finish_note = "用户主动确认收货，订单流转成完成状态";

            $order->saveOrFail();

        });

        if (!isset($order)) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }

        //异步刷新店铺订单统计信息
        $this->queueService->refreshShopOrderSummary($order->shop_id);

        //异步刷新用户订单统计信息
        $this->push(new RefreshUserOrderSummaryJob($this->userId()));

        return $order;
    }

    /**
     * 获取用户的未支付订单
     * @param int $pageIndex
     * @param int $pageSize
     */
    public function getUserNotPayOrderList(int $pageIndex, int $pageSize = 10)
    {
        $list = Order::query()->where('pay_status', Constants::STATUS_WAIT)
            ->where('finish_status', Constants::ORDER_STATUS_PROCESSING)
            ->where('owner_id', $this->userId())
            ->with(['order_goods','shop'])
            ->orderByDesc('order_id')
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();
        $total = Order::query()->where('pay_status', Constants::STATUS_WAIT)
            ->where('finish_status', Constants::ORDER_STATUS_PROCESSING)
            ->where('owner_id', $this->userId())
            ->count();
        return [
            'total' => $total,
            'list' => $list
        ];
    }

    /**
     * 个人根据订单状态获取订单
     * @param int $status
     * @param int $pageIndex
     * @param int $pageSize
     */
    public function getUserOrderListByDeliverStatus(int $status, int $pageIndex, int $pageSize = 10)
    {
        $list = Order::query()->where('deliver_status', $status)
            ->where('pay_status', Constants::STATUS_DONE)
            ->where('finish_status', Constants::ORDER_STATUS_PROCESSING)
            ->where('owner_id', $this->userId())
            ->with(['order_goods','shop'])
            ->orderByDesc('order_id')
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();
        $total = Order::query()->where('deliver_status', $status)
            ->where('pay_status', Constants::STATUS_DONE)
            ->where('finish_status', Constants::ORDER_STATUS_PROCESSING)
            ->where('owner_id', $this->userId())
            ->count();
        return [
            'total' => $total,
            'list' => $list
        ];
    }

    public function getUserFinishOrderList(int $pageIndex, int $pageSize = 10)
    {
        $list = Order::query()->where('finish_status', Constants::STATUS_DONE)
            ->where('pay_status', Constants::STATUS_DONE)
            ->where('owner_id', $this->userId())
            ->with(['order_goods'])
            ->orderByDesc('receive_time')
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();
        $total = Order::query()->where('finish_status', Constants::STATUS_DONE)
            ->where('owner_id', $this->userId())
            ->count();
        return [
            'total' => $total,
            'list' => $list
        ];
    }

    public function getUserOrderTotalInfo()
    {
        return UserOrderSummary::query()->where('owner_id', $this->userId())
            ->orderBy('type')
            ->get()
            ->keyBy('type');
    }

    public function userAppreciate(string $orderNo)
    {
        $order = null;
        Db::transaction(function () use (&$order, $orderNo){
            $order = OrderService::checkOwnOrFail($orderNo);
            $order->is_appreciate = Constants::STATUS_DONE;
            $order->saveOrFail();
        });
        if (!isset($order)){
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }
        return $this->success($order);
    }

    public function refreshUserOrderSummary()
    {
        $this->push(new RefreshUserOrderSummaryJob($this->userId()));
        return $this->success();
    }

    protected function buildOrderGoodsInfo(Order $order)
    {
        $orderGoods = [];
        $order->order_goods->map(function (OrderGood $goods) use (&$orderGoods) {
            $item = $goods->order_goods_name.'x'.$goods->count.$goods->order_unit;
            $orderGoods[] = $item;
        });
        $orderGoodsMessage = implode('; ',$orderGoods);
        return "该顾客的订单商品详情如下:【{$orderGoodsMessage}】";
    }

    /**
     * 通过订单给店铺留言
     * @param string $orderNo
     * @param string $content
     */
    public function addOrderMessage(string $orderNo, string $content)
    {
        //订单归属检测
        OrderService::checkOwnOrFail($orderNo);
        $order = Order::query()->where('order_no', $orderNo)
            ->with(['order_goods','owner'])
            ->first();
        if (!$order instanceof Order) {
            Log::error("($orderNo)订单留言，但是订单不存在!");
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }
        $title = "顾客订单留言通知";
        $message = '单号:【'.$orderNo.'】的顾客【'.$order->nickname.'】发来一条留言:【'.$content.'】';
        $goodsInfo = $this->buildOrderGoodsInfo($order);
        $message .= $goodsInfo;
        $job = new AddShopNotificationJob($order->shop_id,$title,$message);
        $job->levelLabel = "留言";
        $job->level = Constants::MESSAGE_LEVEL_WARN;
        $this->push($job);
    }

    public function addOrderComment(string $orderNo, string $content)
    {
        //订单归属检测
        OrderService::checkOwnOrFail($orderNo);
        $order = Order::query()->where('order_no', $orderNo)
            ->with(['order_goods','owner'])
            ->first();
        if (!$order instanceof Order) {
            Log::error("($orderNo)订单点评，但是订单不存在!");
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }
        $title = "顾客订单点评通知";
        $message = '单号:【'.$orderNo.'】的顾客【'.$order->nickname.'】发来一条点评:【'.$content.'】';
        $goodsInfo = $this->buildOrderGoodsInfo($order);
        $message .= $goodsInfo;
        //保存已点评状态
        $order->is_comment = Constants::STATUS_DONE;
        $order->save();
        $job = new AddShopNotificationJob($order->shop_id,$title,$message);
        $job->level = Constants::MESSAGE_LEVEL_WARN;
        $job->levelLabel = "点评";
        $this->push($job);
    }

    /**
     * 付费订阅
     * @param int $forumId
     */
    public function buyForum(int $forumId)
    {

    }
}