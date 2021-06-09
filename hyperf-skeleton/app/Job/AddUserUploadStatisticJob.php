<?php


namespace App\Job;


use App\Constants\Constants;
use App\Model\User;
use App\Model\UserUploadStatistic;
use ZYProSoft\Log\Log;

class AddUserUploadStatisticJob extends \Hyperf\AsyncQueue\Job
{
    protected int $userId;

    protected string $date;

    public function __construct(int $userId, string $date)
    {
        $this->userId = $userId;
        $this->date = $date;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $statistic = UserUploadStatistic::query()->where('owner_id',$this->userId)
                                                 ->whereDate('upload_date',$this->date)
                                                 ->first();
        if ($statistic instanceof UserUploadStatistic) {
            $statistic->increment('count');
            //用户是不是管理员
//            $user = User::findOrFail($this->userId);
            //非管理员每天上传的限制，暂时不限制
//            if ($user->role_id == 0 && $statistic->count > Constants::USER_MAX_UPLOAD_TIMES_PER_DAY) {
//                $statistic->disable = Constants::STATUS_OK;
//                $statistic->saveOrFail();
//                Log::info("用户($this->userId)昵称($user->nickname)已经达到当日上传次数限制，请注意!");
//            }
            return;
        }
        $statistic = new UserUploadStatistic();
        $statistic->upload_date = $this->date;
        $statistic->owner_id = $this->userId;
        $statistic->count = 1;
        $statistic->save();
    }
}