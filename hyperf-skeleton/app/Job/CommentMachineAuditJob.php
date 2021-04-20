<?php


namespace App\Job;


use App\Service\QiniuAuditService;
use Hyperf\Utils\ApplicationContext;

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
    }
}