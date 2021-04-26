<?php


namespace App\Job;
use App\Service\BaseService;
use Hyperf\AsyncQueue\Job;
use ZYProSoft\Facade\Cache;
use ZYProSoft\Log\Log;

class UniqueJobQueue extends BaseService
{
    private string $commentHotJobPrefix = 'as:up:coh:';

    private string $postJobPrefix = 'as:up:po:';

    private string $userJobPrefix = 'as:up:us:';

    private string $commentJobPrefix = 'as:up:co:';

    private string $subscribeJobPrefix = 'as:us:sb:';

    public function updatePost(int $postId)
    {
        $key = $this->postJobPrefix.$postId;
        $this->uniquePush($key, new PostUpdateJob($postId, $key));
    }

    protected function uniquePush(string $key, Job $job)
    {
        $findJob = Cache::get($key);
        if ($findJob) {
            Log::info($key.'异步任务已经存在，合并本次操作');
            return;
        }
        $this->push($job);
        Cache::set($key, '1');
    }

    public function updateUser(int $userId)
    {
        $key = $this->userJobPrefix.$userId;
        $this->uniquePush($key, new UserUnreadCountJob($key, $userId));
    }

    public function updateComment(int $commentId)
    {
        $key = $this->commentJobPrefix.$commentId;
        $this->uniquePush($key, new CommentUpdateJob($key, $commentId));
    }

    public function updateCommentHot(int $postId)
    {
        $key = $this->commentHotJobPrefix.$postId;
        $this->uniquePush($key, new CommentHotStatusCheckJob($key, $postId));
    }

    public function subscribeForum(int $forumId, int $userId)
    {
        $key = $this->commentHotJobPrefix.$userId.$forumId;
        $this->uniquePush($key, new AutoSubscribeForumJob($key,$userId,$forumId));
    }
}