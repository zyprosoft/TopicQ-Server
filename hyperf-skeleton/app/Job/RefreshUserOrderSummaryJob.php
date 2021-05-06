<?php


namespace App\Job;


use App\Constants\Constants;
use App\Model\Order;
use App\Model\UserOrderSummary;
use Hyperf\DbConnection\Db;
use ZYProSoft\Log\Log;

class RefreshUserOrderSummaryJob extends \Hyperf\AsyncQueue\Job
{
    /**
     * 用户ID
     * @var int
     */
    private int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    protected function saveSummary(int $type, int $total)
    {
        $summary = UserOrderSummary::query()->where('owner_id', $this->userId)
            ->where('type', $type)
            ->first();
        if (!$summary instanceof UserOrderSummary) {
            $summary = new UserOrderSummary();
            $summary->owner_id = $this->userId;
            $summary->type = $type;
        }
        $summary->order_total = $total;
        $summary->save();
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $notPayCount = Order::query()->where('owner_id', $this->userId)
            ->where('pay_status',Constants::STATUS_WAIT)
            ->count();
        Log::info("userId($this->userId) 统计有($notPayCount)待支付");
        $this->saveSummary(Constants::ORDER_SUMMARY_NOT_PAY, $notPayCount);

        $waitDeliverCount = Order::query()->where('owner_id', $this->userId)
            ->where('pay_status',Constants::STATUS_DONE)
            ->where('deliver_status', Constants::STATUS_WAIT)
            ->where('finish_status', Constants::ORDER_STATUS_PROCESSING)
            ->count();
        Log::info("userId($this->userId) 统计有($waitDeliverCount)待发货");
        $this->saveSummary(Constants::ORDER_SUMMARY_WAIT_DELIVER, $waitDeliverCount);

        $finishDeliverCount = Order::query()->where('owner_id', $this->userId)
            ->where('pay_status',Constants::STATUS_DONE)
            ->where('deliver_status', Constants::STATUS_DONE)
            ->where('finish_status', Constants::ORDER_STATUS_PROCESSING)
            ->count();
        Log::info("userId($this->userId) 统计有($finishDeliverCount)已发货");
        $this->saveSummary(Constants::ORDER_SUMMARY_DELIVERED, $finishDeliverCount);

        $finishCount = Order::query()->where('owner_id', $this->userId)
            ->where('pay_status',Constants::STATUS_DONE)
            ->where('finish_status', Constants::STATUS_DONE)
            ->count();
        Log::info("userId($this->userId) 统计有($finishCount)已完成");
        $this->saveSummary(Constants::ORDER_SUMMARY_FINISH, $finishCount);

        Log::info("async update user({$this->userId}) order summary success!");
    }
}