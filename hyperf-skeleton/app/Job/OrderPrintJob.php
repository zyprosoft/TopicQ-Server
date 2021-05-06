<?php


namespace App\Job;
use App\Service\PrinterService;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Job;
use Hyperf\Utils\ApplicationContext;
use ZYProSoft\Log\Log;

class OrderPrintJob extends Job
{
    public string $orderNo;

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

    public function __construct(string $orderNo, int $retryIndex = 0)
    {
        $this->orderNo = $orderNo;
        $this->retryIndex = $retryIndex;
    }

    protected function pushNextJob()
    {
        $configList = collect($this->retryDelayConfig);
        if($this->retryIndex++ > $configList->count()-1) {
            Log::info("($this->orderNo)打印订单任务已经达到最大($this->retryIndex),停止尝试!");
            //到达最大尝试次数，不再执行
            Log::info("尝试打印订单超过次数，不再进行尝试!");
            return;
        }
        $delayTime = $configList[$this->retryIndex++];
        Log::info("订单({$this->orderNo})的第{$this->retryIndex}次打印任务开始尝试!");
        $driverFactory = ApplicationContext::getContainer()->get(DriverFactory::class);
        $driverFactory->get('default')->push(new OrderPrintJob($this->orderNo,$this->retryIndex++),$delayTime);
        Log::info("($this->orderNo)打印订单任务尝试下一次开始!");
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        try {
            $service = ApplicationContext::getContainer()->get(PrinterService::class);
            $service->printerOrder($this->orderNo);
        }catch (\Exception $exception) {
            Log::error("({$this->orderNo})云打印出错，开始下一次尝试!");
            $this->pushNextJob();
        }
    }
}