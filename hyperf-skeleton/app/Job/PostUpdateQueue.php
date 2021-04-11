<?php


namespace App\Job;
use App\Service\BaseService;
use ZYProSoft\Facade\Cache;
use ZYProSoft\Log\Log;

class PostUpdateQueue extends BaseService
{
    private string $jobPrefix = 'as:up:';

    public function update(int $postId)
    {
        $key = $this->jobPrefix.$postId;
        $findJob = Cache::get($key);
        if ($findJob) {
            Log::info($postId.'刷新帖子信息的异步任务已经存在，合并本次操作');
            return;
        }
        $this->push(new PostUpdateJob($postId));
        Cache::set($key, $postId);
        Log::info("($postId)添加添加异步更新任务完成!");
    }
}