<?php


namespace App\Job;
use App\Service\BaseService;
use ZYProSoft\Facade\Cache;
use ZYProSoft\Log\Log;

class UniqueJobQueue extends BaseService
{
    private string $postJobPrefix = 'as:up:po:';

    private string $userJobPrefix = 'as:up:us:';

    public function updatePost(int $postId)
    {
        $key = $this->postJobPrefix.$postId;
        $findJob = Cache::get($key);
        if ($findJob) {
            Log::info($postId.'刷新帖子信息的异步任务已经存在，合并本次操作');
            return;
        }
        $this->push(new PostUpdateJob($postId, $this->postJobPrefix));
        Cache::set($key, $postId);
    }

    public function updateUser(int $userId)
    {

    }
}