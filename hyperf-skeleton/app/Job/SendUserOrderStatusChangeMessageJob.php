<?php


namespace App\Job;
use App\Constants\Constants;
use App\Model\Order;
use App\Model\User;
use App\Service\NotificationService;
use EasyWeChat\Factory;
use Hyperf\AsyncQueue\Job;
use Hyperf\Utils\ApplicationContext;
use ZYProSoft\Log\Log;

class SendUserOrderStatusChangeMessageJob extends Job
{
    /**
     * 待发送订单
     * @var string
     */
    private string $orderNo;

    public function __construct(string $orderNo)
    {
        $this->orderNo = $orderNo;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        //先查找订单
        $order = Order::query()->where('order_no', $this->orderNo)->with(['shop'])->first();
        if (!$order instanceof Order) {
            Log::error("order({$this->orderNo}) not found !");
            return;
        }

        //现在只发送站内通知信息
        $deliverStatus = $order->deliver_status==Constants::STATUS_WAIT?'待发货':'已发货';
        $tab = $order->deliver_status==Constants::STATUS_WAIT? 1:2;
        $message = "您的订单【{$order->order_no}】已进入{$deliverStatus}状态";
        $title = "订单状态已更新";
        $levelLabel = "订单";
        $level = Constants::MESSAGE_LEVEL_ERROR;
        $service = ApplicationContext::getContainer()->get(NotificationService::class);
        $keyInfo = json_encode(['order_no'=>$order->order_no,'tab'=>$tab]);
        $service->create($order->owner_id,$title,$message,false,$level,$levelLabel,$keyInfo);

        $miniProgramConfig = config('weixin.miniProgram');
        Log::info('min program config:'.json_encode($miniProgramConfig));
        $app = Factory::miniProgram($miniProgramConfig);

        //获取用户的openID
        $user = User::find($order->owner_id);
        Log::info("find user:".json_encode($user));
        if (!$user instanceof User) {
            Log::info("({$order->owner_id})获取用户失败!");
            return;
        }
        $orderOwnerOpenID = $user->wx_openid;
        Log::info("openId:".$orderOwnerOpenID);

        //生成订单送货状态
        $deliverStatus = $order->deliver_status==Constants::STATUS_WAIT?'待配送':'已配送';

        $data = [
            'template_id' => 'erJZPEVDMHuH5pQ0T0QaNCXDlod_6waZhP31FKBsfeQ', // 所需下发的订阅模板id
            'touser' => $orderOwnerOpenID,     // 接收者（用户）的 openid
            'page' => '/pages/index/index?page=my',       // 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
            'miniprogram_state'=> config('weixin.miniProgram.env'),
            'data' => [         // 模板内容，格式形如 { "key1": { "value": any }, "key2": { "value": any } }
                'character_string1' => [
                    'value' => $order->order_no
                ],
                'thing2' => [
                    'value' => $order->shop->name,
                ],
                'phrase21' => [
                    'value' => $deliverStatus,
                ],
                'time22' => [
                    'value' => $order->deliver_time,
                ],
            ],
        ];

        Log::info('will send subscribe message:'.json_encode($data));

        $result = $app->subscribe_message->send($data);

        Log::info('async send order status change message result:'.json_encode($result));
        Log::info("async send order status change message to customer finished!");
    }
}