<?php


namespace App\Job;
use App\Constants\Constants;
use App\Model\Order;
use App\Service\WxPayService;
use Carbon\Carbon;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Job;
use Hyperf\DbConnection\Db;
use Hyperf\Utils\ApplicationContext;
use ZYProSoft\Log\Log;

class RefreshOrderPayStatusJob extends Job
{
    /**
     * 订单号
     * @var string
     */
    private string $orderNo;

    /**
     * 当前尝试次数
     * @var int
     */
    private int $retryIndex;

    /**
     * 尝试次数的延迟时间配置,秒
     * @var array
     */
    private array $retryDelayConfig = [
        5,
        30,
        60,
        180,
        300,
        600,
        1800
    ];

    public function __construct(string $orderNo, int $currentTryIndex = 0)
    {
        $this->retryIndex = $currentTryIndex;
        $this->orderNo = $orderNo;
    }

    /**
     * 基于当前任务的信息，push下一次任务
     */
    protected function pushNextJob()
    {
        $configList = collect($this->retryDelayConfig);
        if($this->retryIndex++ > $configList->count()-1) {
            Log::info("($this->orderNo)查询订单支付状态任务已经达到最大($this->retryIndex),停止尝试!");
            //到达最大尝试次数，执行关闭订单
            $service = ApplicationContext::getContainer()->get(WxPayService::class);
            $result = $service->closeOrder($this->orderNo);
            $status = $result?"成功":"失败";
            Log::info("尝试微信关闭订单($this->orderNo)执行结果:$status");
            return;
        }
        $delayTime = $configList[$this->retryIndex++];
        Log::info("订单({$this->orderNo})的第{$this->retryIndex}次查询支付状态任务开始尝试!");
        $driverFactory = ApplicationContext::getContainer()->get(DriverFactory::class);
        $driverFactory->get('default')->push(new RefreshOrderPayStatusJob($this->orderNo,$this->retryIndex++),$delayTime);
        Log::info("($this->orderNo)查询订单支付状态任务尝试下一次查询开始!");
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        //事务执行
        Db::transaction(function () {
            //当前订单是不是已经支付成功了
            $order = Order::query()->where('order_no',$this->orderNo)
                ->lockForUpdate()
                ->first();
            if (!$order instanceof Order) {
                Log::info("异步查询订单任务找不到订单($this->orderNo)!");
                return;
            }
            if ($order->pay_status == Constants::STATUS_DONE) {
                Log::info("异步查询订单任务查到当前订单已经支付成功");
                return;
            }
            if ($order->pay_status == Constants::STATUS_INVALIDATE) {
                Log::info("异步查询订单任务发现订单已经是失效取消状态");
                return;
            }
            //刷新订单的状态，尝试指定次数
            $service = ApplicationContext::getContainer()->get(WxPayService::class);
            $status = $service->checkOrderPayStatus($this->orderNo);
            if ($status) {
                Log::info("异步任务获取到订单($this->orderNo)已经支付，开始刷新订单支付状态");
                $order->pay_status = Constants::STATUS_DONE;
                $order->pay_time = Carbon::now()->toDateTimeString();
                $order->pay_status_note = "异步任务查询订单状态为已支付状态并且更新!";
                $result = $order->save();
                if ($result == false){
                    Log::info("异步任务保存订单支付状态失败,开始执行下一次任务");
                    $this->pushNextJob();
                }else{
                    Log::info("异步任务保存订单状态成功");
                }
            }else{
                Log::error("异步任务查询到订单仍然是未支付状态,开始执行下一次任务");
                $this->pushNextJob();
            }
        });
    }
}