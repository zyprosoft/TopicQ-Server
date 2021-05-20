<?php


namespace App\Service\Admin;
use App\Model\AppSetting;
use App\Service\BaseService;

class SettingService extends BaseService
{
    public function info()
    {
        return AppSetting::firstOrFail();
    }

    public function update(array $params)
    {
        $appSetting = AppSetting::firstOrFail();
        if (isset($params[''])) {

        }
    }
}