<?php


namespace App\Task;


use App\Constants\Constants;
use App\Model\Voucher;
use Carbon\Carbon;
use ZYProSoft\Log\Log;

class VoucherExpireTask
{
    public function execute()
    {
        //所有结束时间晚于当天的都过期掉
        $now = Carbon::now()->toDateString();
        Voucher::query()->whereDate('end_time','<', $now)
                        ->update([
                            'status' => Constants::VOUCHER_STATUS_EXPIRED,
                        ]);
        Log::info("执行代金券过期任务完成!");
    }
}