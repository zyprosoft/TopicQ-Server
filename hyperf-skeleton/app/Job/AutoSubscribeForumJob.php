<?php


namespace App\Job;
use App\Model\UserSubscribe;
use App\Service\ForumService;
use Hyperf\AsyncQueue\Job;
use Hyperf\Utils\ApplicationContext;
use ZYProSoft\Facade\Cache;
use ZYProSoft\Log\Log;

class AutoSubscribeForumJob extends Job
{
    private string $cacheKey;

    public int $userId;

    public int $forumId;

    public function __construct(string $cacheKey, int $userId, int $forumId)
    {
        $this->cacheKey = $cacheKey;
        $this->userId = $userId;
        $this->forumId = $forumId;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        Cache::delete($this->cacheKey);
        $subscribe = new UserSubscribe();
        $subscribe->user_id = $this->userId;
        $subscribe->forum_id = $this->forumId;
        $subscribe->saveOrFail();
        Log::info("异步帮助用户($this->userId)订阅板块($this->forumId)完成!");
    }
}