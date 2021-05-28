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

    public string $desc;

    public function __construct(int $userId, string $bindAction, string $desc)
    {
        $this->bindAction = $bindAction;
        $this->userId = $userId;
        $this->desc = $desc;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $scoreService = ApplicationContext::getContainer()->get(ScoreService::class);
        $scoreService->addScore($this->userId,$this->bindAction,$this->desc);
        Log::info("用户({$this->userId})行为($this->desc)加分完成!");
    }
}