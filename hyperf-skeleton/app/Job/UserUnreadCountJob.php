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
        $total = Comment::query()->select(['comment.comment_id','owner_id','user_id'])
                                 ->leftJoin('user_comment_read','comment.comment_id','=','user_comment_read.comment_id')
                                 ->where('parent_comment_owner_id', $this->userId)
                                 ->orWhere('post_owner_id', $this->userId)
                                 ->whereNull('user_id')
                                 ->count();
        $user->unread_comment_count = $total;

        $user->saveOrFail();
    }
}