<?php


namespace App\Service;
use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Job\AutoDeliverySubscribeGoodsJob;
use App\Job\OrderPrintJob;
use App\Job\RefreshUserOrderSummaryJob;
use App\Model\Good;
use App\Model\Order;
use App\Model\Shop;
use App\Model\User;
use Carbon\Carbon;
use EasyWeChat\Factory;
use Hyperf\DbConnection\Db;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Log\Log;

class WxPayService extends BaseService
{
    /**
     * 需要识别为支付成功的错误码
     */
    const WX_PAY_NEED_SUCCESS_ERROR_CODE = 'ORDERPAID';

    const WX_REQUEST_SUCCESS_CODE = 'SUCCESS';

    const WX_REQUEST_FAIL_CODE = 'FAIL';

    /**
     * 小程序配置
     * @var array
     */
    private array $paymentConfig = [];

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->paymentConfig = config('weixin.payment');
    }

    public function handle(Request $request)
    {
        Log::info('payment config:' . json_encode($this->paymentConfig));
        $app = Factory::payment($this->paymentConfig);
        $app->rebind("request", $request);
        return $app->handlePaidNotify(function ($message, $fail) {

            $order = null;

            Db::transaction(function () use ($message, $fail, &$order) {

                $orderNo = data_get($message, 'out_trade_no');
                $order = Order::query()->where('order_no', $orderNo)->lockForUpdate()->first();
                if (!$order instanceof Order) {
                    Log::info("($orderNo)订单不存在!");
                    return true;
                }

                if ($order->pay_status == Constants::STATUS_DONE) {
                    Log::info("($orderNo)订单已经支付成功");
                    return true;
                }

                //查询微信订单状态
                $checkResult = $this->checkOrderPayStatus($orderNo);
                if ($checkResult == false) {
                    return $fail('通信失败，请稍后再通知我');
                }

                //检查本次通知的结果
                if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                    // 用户是否支付成功
                    if (data_get($message, 'result_code') === 'SUCCESS') {

                        //校验订单金额是否一致
                        if($order->cash != data_get($message,'total_fee')) {
                            //订单金额不一致，可能是伪造请求
                            return $fail('通信失败，请稍后再通知我');
                        }

                        $order->pay_time = Carbon::now()->toDateTimeString(); // 更新支付时间为当前时间
                        $order->pay_status = Constants::STATUS_DONE;
                        $order->pay_status_note = '微信支付回调通知支付成功确认完成';

                        //查看订单是不是订阅商品
                        $orderGoods = $order->order_goods->first();
                        $goods = Good::find($orderGoods->goods_id);
                        Log::info("订单第一个商品:".json_encode($goods));
                        if($goods instanceof Good) {
                            if ($goods->bind_forum_id > 0) {
                                //自动发货
                                $this->push(new AutoDeliverySubscribeGoodsJob($order->order_no,$order->owner_id,$goods->bind_forum_id));
                            }
                        }

                        // 用户支付失败
                    } elseif (data_get($message, 'result_code') === 'FAIL') {
                        Log::error("订单号($order->order_no)微信回调通知用户支付失败!");
                        $order->pay_status = Constants::STATUS_WAIT;
                        $order->wx_prepay_id = null;
                        $order->wx_prepay_id_time = null;
                        Log::info("订单号($order->order_no)重置微信统一订单，以便重新生成支付!");
                        return $fail('通信失败，请稍后再通知我');
                    }
                } else {
                    Log::error("($order->order_no)微信通知通信失败！");
                    return $fail('通信失败，请稍后再通知我');
                }

                //更新订单支付状态
                $result = $order->save();
                if ($result == false) {
                    Log::error("($order->order_no)更新订单状态失败，请管理员及时关注");
                    return $fail('通信失败，请稍后再通知我');
                }

//                return true;//不return继续做别的任务
            });

            if (!$order instanceof Order) {
                return $fail('通信失败，请稍后再通知我');
            }

            //异步处理订单相关的数据,必须要签名的任务提交了，这个才能异步处理
            $this->asyncRefreshOrderJob($order);

            return true;
        });
    }

    /**
     * 异步处理订单相关的数据
     * @param Order $order
     */
    public function asyncRefreshOrderJob(Order $order)
    {
        //打印订单
        $this->push(new OrderPrintJob($order->order_no));
        
        //异步刷新用户订单统计信息
        $this->push(new RefreshUserOrderSummaryJob($order->owner_id));

        //下单成功，异步刷新店铺信息
        $this->queueService->refreshShopInfo($order->shop_id);

        //异步刷新店铺订单统计信息
        $this->queueService->refreshShopOrderSummary($order->shop_id);
    }

    public function checkOrderPayStatus(string $orderNo)
    {
        Log::info('payment config:'.json_encode($this->paymentConfig));
        $app = Factory::payment($this->paymentConfig);
        try {
            $result = $app->order->queryByOutTradeNumber($orderNo);
            //判断交易成功的条件
            if ($result['return_code'] == self::WX_REQUEST_SUCCESS_CODE &&
                $result['result_code'] == self::WX_REQUEST_SUCCESS_CODE &&
                $result['trade_state'] == self::WX_REQUEST_SUCCESS_CODE
            ) {
                Log::info("check order($orderNo) status pay success!");
                return true;
            }
            Log::info("check order($orderNo) status pay fail!");
            return  false;
        }catch (\Exception $exception) {
            Log::error('wxpay check order error code:'.$exception->getCode());
            Log::error('wxpay check order error msg:'.$exception->getMessage());
            return false;
        }
    }

    /**
     * 获取微信支付的统一支付订单号
     * @param Order $order
     * @param User $owner
     * @param Shop $shop
     */
    public function genOrderSignInfo(Order $order, User $owner, Shop $shop)
    {
        Log::info('payment config:'.json_encode($this->paymentConfig));
        $app = Factory::payment($this->paymentConfig);

        //商品名称
        $orderGoods = collect($order->order_goods);
        $orderFirst = $orderGoods->first();
        $goodsName = $orderFirst->order_goods_name.'x'.$orderFirst->count.$orderFirst->order_unit;
        if($orderGoods->count() > 1) {
            $goodsName .= '等';
        }
        $body = $shop->name.'-'.$goodsName;

        try {
            $unifyParam = [
                'body' => $body,
                'out_trade_no' => $order->order_no,
                'total_fee' => $order->cash,
                'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
                'openid' => $owner->wx_openid,
            ];
            Log::info('unify order param:'.json_encode($unifyParam));
            $result = $app->order->unify($unifyParam);
        }catch (\Throwable $exception) {
            throw new HyperfCommonException(ErrorCode::REQUEST_WX_PAY_FAIL);
        }
        Log::info('wxpay request prepay_id result:'.json_encode($result));

        //支付结果保存
        if($result['return_code'] !== self::WX_REQUEST_SUCCESS_CODE) {
            Log::error('请求微信支付通信失败，抛出异常!');
            throw new HyperfCommonException(ErrorCode::REQUEST_WX_PAY_FAIL);
        }

        $resultCode = data_get($result,'result_code');

        if($resultCode !== self::WX_REQUEST_SUCCESS_CODE) {

            $errorCode = data_get($result,'err_code');

            //是不是需要识别为成功
            if($errorCode !== self::WX_PAY_NEED_SUCCESS_ERROR_CODE) {
                Log::error('请求微信支付处理结果失败，抛出异常!');
                throw new HyperfCommonException(ErrorCode::REQUEST_WX_PAY_FAIL);
            }

            Log::info('订单已经是支付状态无需更新');
            throw new HyperfCommonException(ErrorCode::ORDER_DID_FINISH_PAY);
        }

        //保存订单的微信支付订单号
        $prepayId = data_get($result,'prepay_id');
        $prepayIdTime = Carbon::now()->toDateTimeString();
        $order->wx_prepay_id = $prepayId;
        $order->wx_prepay_id_time = $prepayIdTime;
        $order->wx_prepay_body = $body;
        $order->saveOrFail();

        //生成签名信息
        return $app->jssdk->bridgeConfig($prepayId,false);
    }

    /**
     * @param string $prepayId
     * @param string $nonceStr
     * @return array
     */
    public function getPrepaySignInfo(string $prepayId)
    {
        Log::info('payment config:'.json_encode($this->paymentConfig));
        $app = Factory::payment($this->paymentConfig);
        //生成签名信息
        return $app->jssdk->bridgeConfig($prepayId,false);
    }

    public function closeOrder(string $orderNo)
    {
        Db::transaction(function () use ($orderNo) {
            //订单支付状态是不是已经成功或者失效关闭状态
            $order = Order::query()->where('order_no', $orderNo)->lockForUpdate()->first();
            if (!$order instanceof Order) {
                Log::info("关闭订单时($orderNo)找不到对应的订单!");
                return false;
            }
            if ($order->pay_status == Constants::STATUS_DONE) {
                Log::info("关闭订单($orderNo)查到当前订单已经支付成功");
                return false;
            }
            if ($order->pay_status == Constants::STATUS_INVALIDATE) {
                Log::info("关闭订单($orderNo)发现订单已经是失效取消状态");
                return false;
            }

            //开始尝试关闭
            Log::info('payment config:'.json_encode($this->paymentConfig));
            $app = Factory::payment($this->paymentConfig);
            try {
                $result = $app->order->close($orderNo);
                //判断交易成功的条件
                if ($result['return_code'] == self::WX_REQUEST_SUCCESS_CODE &&
                    $result['result_code'] == self::WX_REQUEST_SUCCESS_CODE
                ) {
                    Log::info("从微信支付查询到($orderNo)关闭执行成功!");
                    //保存订单成关闭
                    $order->pay_status = Constants::STATUS_INVALIDATE;
                    $order->pay_status_note = "订单已经被系统执行关闭!";
                    return $order->save();
                }
                Log::info("close order($orderNo) fail!");
                return  false;
            }catch (\Exception $exception) {
                Log::error('wxpay close order error code:'.$exception->getCode());
                Log::error('wxpay close order error msg:'.$exception->getMessage());
                return false;
            }
        });
    }
}