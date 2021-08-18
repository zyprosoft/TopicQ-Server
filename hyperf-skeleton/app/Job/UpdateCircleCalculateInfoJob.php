<?php


namespace App\Job;
use App\Constants\Constants;
use App\Model\Circle;
use App\Model\CircleTopic;
use App\Model\Post;
use App\Model\UserCircle;
use Hyperf\AsyncQueue\Job;
use ZYProSoft\Facade\Cache;

class UpdateCircleCalculateInfoJob extends Job
{
    private string $cacheKey;

    protected int $circleId;

    public function __construct(int $circleId, string $cacheKey)
    {
        $this->cacheKey = $cacheKey;
        $this->circleId = $circleId;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        Cache::delete($this->cacheKey);
        //统计话题
        $topicCount = CircleTopic::query()->where('circle_id',$this->circleId)->count();
        //统计动态
        $activeCount = Post::query()
            ->where('circle_id',$this->circleId)
            ->where('audit_status',Constants::STATUS_OK)
            ->count();
        $memberCount = UserCircle::query()->where('circle_id',$this->circleId)
                                          ->count();
        $memberCount += 1;
        $circle = Circle::findOrFail($this->circleId);
        $circle->post_count = $activeCount;
        $circle->member_count = $memberCount;
        $circle->topic_count = $topicCount;
        $circle->saveOrFail();
    }
}