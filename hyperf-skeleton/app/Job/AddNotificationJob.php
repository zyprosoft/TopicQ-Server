<?php


namespace App\Job;
use App\Constants\Constants;
use App\Service\NotificationService;
use Hyperf\AsyncQueue\Job;
use Hyperf\Utils\ApplicationContext;
use ZYProSoft\Log\Log;

class AddNotificationJob extends Job
{
    public int $userId;

    public string $title;

    public string $content;

    public bool $isTop;

    public int $level;

    public string $levelLabel;

    public string $keyInfo;

    public function __construct(int $userId, string $title, string $content, $isTop = false, int $level = Constants::MESSAGE_LEVEL_NORMAL, string $levelLabel = '')
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->content = $content;
        $this->isTop = $isTop;
        $this->level = $level;
        $this->levelLabel = $levelLabel;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $service = ApplicationContext::getContainer()->get(NotificationService::class);
        $service->create($this->userId, $this->title, $this->content, $this->isTop, $this->level, $this->levelLabel);
        Log::info("用户($this->userId) 增加消息($this->content)通知异步执行完成!");
    }
}