<?php


namespace App\Job;
use App\Model\ScoreAction;
use App\Service\ScoreService;
use Hyperf\AsyncQueue\Job;
use Hyperf\Utils\ApplicationContext;
use ZYProSoft\Log\Log;

class AddScoreJob extends Job
{
    public string $bindAction;

    public int $userId;

    public function __construct(int $userId, string $bindAction)
    {
        $this->bindAction = $bindAction;
        $this->userId = $userId;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $scoreService = ApplicationContext::getContainer()->get(ScoreService::class);
        $scoreService->addScore($this->userId,$this->bindAction);
        Log::info("用户({$this->userId})行为($this->bindAction)加分完成!");
    }
}