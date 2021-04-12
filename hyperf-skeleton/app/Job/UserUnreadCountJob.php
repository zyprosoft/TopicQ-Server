<?php


namespace App\Job;
use App\Constants\Constants;
use App\Model\Comment;
use App\Model\User;
use Hyperf\AsyncQueue\Job;

class UserUnreadCountJob extends Job
{
    public string $jobPrefix;

    public int $userId;

    public function __construct(string $jobPrefix, int $userId)
    {
        $this->jobPrefix = $jobPrefix;
        $this->userId = $userId;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $user = User::findOrFail($this->userId);
        //统计回复未看的数量
        $total = Comment::query()->where('parent_comment_owner_id', $this->userId)
                                 ->where('parent_comment_owner_is_read', Constants::STATUS_WAIT)
                                 ->count();
        
    }
}