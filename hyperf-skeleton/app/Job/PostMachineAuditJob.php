<?php


namespace App\Job;
use App\Service\QiniuAuditService;
use Hyperf\AsyncQueue\Job;
use Hyperf\Utils\ApplicationContext;
use ZYProSoft\Log\Log;

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
        Log::info("($this->postId)异步审核帖子文本信息执行完成!");
    }
}