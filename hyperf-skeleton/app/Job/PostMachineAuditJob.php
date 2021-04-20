<?php


namespace App\Job;
use Hyperf\AsyncQueue\Job;

class PostMachineAuditJob extends Job
{
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
        //文本审核
    }
}