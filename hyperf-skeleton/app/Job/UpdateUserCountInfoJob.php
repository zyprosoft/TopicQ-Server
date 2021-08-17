<?php


namespace App\Job;
use App\Constants\Constants;
use App\Model\Post;
use App\Model\User;
use App\Model\UserAttentionOther;
use Hyperf\AsyncQueue\Job;
use ZYProSoft\Facade\Cache;

class UpdateUserCountInfoJob extends Job
{
    private string $cacheKey;

    protected int $userId;

    public function __construct(int $userId,string $cacheKey)
    {
        $this->cacheKey = $cacheKey;
        $this->userId = $userId;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        Cache::delete($this->cacheKey);
        $user = User::findOrFail($this->userId);
        //统计用户的帖子数
        $activeCount = Post::query()->where('owner_id',$this->userId)
                                    ->where('circle_id','>', Constants::STATUS_NOT)
                                    ->count();
        $postCount = Post::query()->where('owner_id',$this->userId)
                                  ->where('circle_id',Constants::STATUS_NOT)
                                  ->count();
        $fansCount = UserAttentionOther::query()->where('other_user_id',$this->userId)
                                                ->count();

        $attentionCount = UserAttentionOther::query()->where('user_id',$this->userId)
                                                     ->count();
        $user->active_count = $activeCount;
        $user->post_count = $postCount;
        $user->fans_count = $fansCount;
        $user->attention_count = $attentionCount;
        $user->saveOrFail();
    }
}