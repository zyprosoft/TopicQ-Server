<?php


namespace App\Job;


use App\Constants\Constants;
use App\Service\Admin\OrderService;
use App\Service\ForumService;
use Hyperf\Utils\ApplicationContext;
use ZYProSoft\Log\Log;

class AutoDeliverySubscribeGoodsJob extends \Hyperf\AsyncQueue\Job
{
    protected string $orderNo;

    protected int $userId;

    protected int $forumId;

    public function __construct(string $orderNo, int $userId, int $forumId)
    {
        $this->orderNo = $orderNo;
        $this->userId = $userId;
        $this->forumId = $forumId;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        Log::info("订单($this->orderNo)开始执行自动订阅发货!");
        $container = ApplicationContext::getContainer();
        $service = $container->get(ForumService::class);
        $service->subscribe($this->forumId,$this->userId);
        Log::info("帮助用户({$this->userId})完成订阅板块({$this->forumId})发货成功");
        //执行订单状态变化
        $orderService = $container->get(OrderService::class);
        $orderService->updateDeliverStatus($this->orderNo,Constants::STATUS_OK);
        Log::info("订单($this->orderNo)完成订阅板块自动发货任务!");
    }
}