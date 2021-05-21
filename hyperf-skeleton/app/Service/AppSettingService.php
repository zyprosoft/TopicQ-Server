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

    public function getInfoNoFail()
    {
        return AppSetting::first();
    }

    public static function isUserUploadVideoEnable()
    {
        $appSetting = AppSetting::first();
        if (!$appSetting instanceof AppSetting) {
            return false;
        }
        return  $appSetting->enable_user_video == 1;
    }

    public static function isUserCreateTopicEnable()
    {
        $appSetting = AppSetting::first();
        if (!$appSetting instanceof AppSetting) {
            return false;
        }
        return  $appSetting->enable_user_create_topic == 1;
    }
}