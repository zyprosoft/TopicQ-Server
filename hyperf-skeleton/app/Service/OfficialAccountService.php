<?php


namespace App\Service;
use ZYProSoft\Log\Log;
use ZYProSoft\Service\AbstractService;

class OfficialAccountService extends AbstractService
{
    public function notify()
    {
        Log::info("receive wx notify");
    }
}