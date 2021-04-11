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
    private string $jobPrefix = 'as:up:';

    public int $postId;

    public function __construct(int $postId)
    {
        $this->postId = $postId;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        //删除队列标记位
        $key = $this->jobPrefix.$this->postId;
        Cache::delete($key);

        Log::info("开始执行刷新帖子($this->postId)的异步任务");

        Db::transaction(function (){

            $post = Post::query()->where('post_id', $this->postId)->lockForUpdate()->first();
            if (!$post instanceof Post) {
                Log::error('未找到帖子:'.$this->postId);
                return;
            }

            //统计评论数
            $commentCount = Comment::query()->where('post_id', $this->postId)
                ->count();
            $post->comment_count = $commentCount;

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
        });

        Log::info("帖子($this->postId) 异步刷新信息完成!");
    }
}