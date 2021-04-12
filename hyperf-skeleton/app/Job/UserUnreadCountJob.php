<?php


namespace App\Job;
use App\Constants\Constants;
use App\Model\Comment;
use App\Model\User;
use ZYProSoft\Facade\Cache;
use Hyperf\AsyncQueue\Job;

class UserUnreadCountJob extends Job
{
    public string $cacheKey;

    public int $userId;

    public function __construct(string $cacheKey, int $userId)
    {
        $this->cacheKey = $cacheKey;
        $this->userId = $userId;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        //删除队列Key
        Cache::delete($this->cacheKey);

        $user = User::findOrFail($this->userId);

        //统计回复未看的数量
        $total = Comment::query()->where('parent_comment_owner_id', $this->userId)
                                 ->where('parent_comment_owner_is_read', Constants::STATUS_WAIT)
                                 ->count();
        $user->unread_reply_count = $total;

        //统计评论未看数量


        $user->saveOrFail();
    }
}