<?php


namespace App\Job;
use App\Model\Comment;
use App\Model\Post;
use App\Model\UserFavorite;
use Hyperf\AsyncQueue\Job;
use Hyperf\DbConnection\Db;
use ZYProSoft\Facade\Cache;
use ZYProSoft\Log\Log;

class PostUpdateJob extends Job
{
    private string $cacheKey;

    public int $postId;

    public function __construct(int $postId, string $cacheKey)
    {
        $this->postId = $postId;
        $this->cacheKey = $cacheKey;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        //删除队列标记位
        Cache::delete($this->cacheKey);

        Log::info("开始执行刷新帖子($this->postId)的异步任务");

        $post = Post::query()->where('post_id', $this->postId)
                            ->with(['vote'])
                            ->first();
        if (!$post instanceof Post) {
            Log::error('未找到帖子:'.$this->postId);
            return;
        }

        //统计评论数
        $commentCount = Comment::query()->where('post_id', $this->postId)
            ->count();
        $post->comment_count = $commentCount;

        //统计参与人数
        $userCount = Comment::query()->select(['owner_id'])
                                     ->groupBy(['owner_id'])
                                     ->get()
                                     ->count();
        $post->join_user_count = $userCount;
        if (isset($post->vote_id)) {
            $post->join_user_count = $post->vote->total_user + $userCount;
        }

        //统计收藏数
        $favoriteCount = UserFavorite::query()->where('post_id', $this->postId)
            ->count();
        $post->favorite_count = $favoriteCount;

        //最后一条回复
        $comment = Comment::query()->where('post_id', $this->postId)
            ->latest()
            ->first();
        if ($comment instanceof Comment) {
            $post->last_comment_time = $comment->created_at;
        }

        $post->saveOrFail();

        Log::info("帖子($this->postId) 异步刷新信息完成!");
    }
}