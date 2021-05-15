<?php


namespace App\Service;
use App\Model\AppSetting;
use ZYProSoft\Service\AbstractService;

class AppSettingService extends AbstractService
{
    public function getSettingInfo()
    {
        return AppSetting::firstOrFail();
    }
}