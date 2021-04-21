<?php


namespace App\Job;


use App\Service\QiniuAuditService;
use Hyperf\Utils\ApplicationContext;
use ZYProSoft\Log\Log;

class UserUpdateMachineAuditJob extends \Hyperf\AsyncQueue\Job
{
    public int $updateId;

    public function __construct(int $updateId)
    {
        $this->updateId = $updateId;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $service = ApplicationContext::getContainer()->get(QiniuAuditService::class);
        $service->auditUserUpdate($this->updateId);
        Log::info("($this->updateId)异步审核用户资料更新执行完成");
    }
}