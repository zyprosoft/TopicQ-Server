<?php


namespace App\Job;
use App\Service\OfficialAccountService;
use Hyperf\AsyncQueue\Job;
use Hyperf\Utils\ApplicationContext;

class QueryOfficialAccountUserInfoJob extends Job
{
    private string $openId;

    public function __construct(string $openId)
    {
        $this->openId = $openId;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $service = ApplicationContext::getContainer()->get(OfficialAccountService::class);
        $service->queryUserInfo($this->openId);
    }
}