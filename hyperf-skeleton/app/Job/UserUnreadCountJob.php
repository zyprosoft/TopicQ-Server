<?php


namespace App\Job;
use App\Constants\Constants;
use App\Model\Comment;
use App\Model\User;
use Hyperf\DbConnection\Db;
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

        $userId = $this->userId;
        //统计回复未看的数量
        $unreadList = Db::select("select comment_id from comment where post_owner_id = ? or parent_comment_owner_id = ? and comment_id not in (select comment_id from user_comment_read where user_id = ?)",[$userId,$userId,$userId]);

        $user->unread_comment_count = count($unreadList);

        $user->saveOrFail();
    }
}