<?php


namespace App\Service;


use App\Constants\Constants;
use App\Model\Activity;

class ActivityService extends BaseService
{
    public function getActivityList()
    {
        return Activity::query()->where('status',Constants::STATUS_WAIT)->get();
    }
}