<?php


namespace App\Job;
use App\Constants\Constants;
use App\Model\CircleTopic;
use App\Model\Post;
use Hyperf\AsyncQueue\Job;
use ZYProSoft\Facade\Cache;

class UpdateCircleTopicCountInfoJob extends Job
{
    private string $cacheKey;

    protected int $topicId;

    public function __construct(int $topicId, string $cacheKey)
    {
        $this->cacheKey = $cacheKey;
        $this->topicId = $topicId;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        Cache::delete($this->cacheKey);
        $postCount = Post::query()->where('circle_topic_id',$this->topicId)
                                  ->where('audit_status',Constants::STATUS_OK)
                                  ->count();
        $memberCount = Post::query()->selectRaw('distinct owner_id')
            ->where('circle_topic_id',$this->topicId)
            ->where('audit_status',Constants::STATUS_OK)
            ->count();
        $circleTopic = CircleTopic::findOrFail($this->topicId);
        $circleTopic->post_count = $postCount;
        $circleTopic->member_count = $memberCount;
        $circleTopic->saveOrFail();
    }
}