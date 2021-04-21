<?php


namespace App\Job;


use App\Service\QiniuAuditService;
use Hyperf\Utils\ApplicationContext;
use ZYProSoft\Log\Log;

class CommentMachineAuditJob extends \Hyperf\AsyncQueue\Job
{
    public int $commentId;

    public function __construct(int $commentId)
    {
        $this->commentId = $commentId;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $service = ApplicationContext::getContainer()->get(QiniuAuditService::class);
        $service->auditComment($this->commentId);
        Log::info("($this->commentId)异步审核评论文本信息执行完成!");
    }
}