<?php


namespace App\Job;
use App\Service\QiniuAuditService;
use Hyperf\AsyncQueue\Job;
use Hyperf\Utils\ApplicationContext;

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
        $service = ApplicationContext::getContainer()->get(QiniuAuditService::class);
        $service->auditPost($this->postId);
    }
}