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

    public function update(string $column, int $status)
    {
        $appSetting = AppSetting::firstOrFail();
        $appSetting->{$column} = $status;
        $appSetting->saveOrFail();
    }
}