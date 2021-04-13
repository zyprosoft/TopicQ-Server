<?php


namespace App\Job;
use App\Model\Comment;
use Hyperf\AsyncQueue\Job;
use ZYProSoft\Facade\Cache;
use ZYProSoft\Log\Log;

class CommentUpdateJob extends Job
{
    public int $commentId;

    public string $cacheKey;

    public function __construct(string $cacheKey,int $commentId)
    {
        $this->commentId = $commentId;
        $this->cacheKey = $cacheKey;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        Cache::delete($this->cacheKey);
        $comment = Comment::find($this->commentId);
        if (!$comment instanceof Comment) {
            Log::info("评论异步更新任务未找到评论:$this->commentId");
            return;
        }
        //统计回复总数
        $totalReply = Comment::query()->where('parent_comment_id', $this->commentId)
                                      ->count();
        $comment->reply_count = $totalReply;
        $comment->saveOrFail();
    }
}