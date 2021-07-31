<?php


namespace App\Job;


use App\Service\CircleService;
use Hyperf\Utils\ApplicationContext;
use Hyperf\AsyncQueue\Job;
use ZYProSoft\Facade\Cache;

class UpdateUserCircleInfoJob extends Job
{
    private string $cacheKey;

    protected int $userId;

    protected int $circleId;

    public function __construct(int $userId, int $circleId, string $cacheKey)
    {
        $this->userId = $userId;
        $this->circleId = $circleId;
        $this->cacheKey = $cacheKey;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        Cache::delete($this->cacheKey);
        $service = ApplicationContext::getContainer()->get(CircleService::class);
        $service->updateUserCircleActiveTime($this->userId,$this->circleId);
    }
}