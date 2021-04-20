<?php


namespace App\Job;
use App\Service\QiniuAuditService;
use Hyperf\AsyncQueue\Job;
use Hyperf\Utils\ApplicationContext;

class ImageAuditUpdateJob extends Job
{
    public int $ownerId;

    public int $ownerType;

    public int $auditStatus;

    public string $imageID;

    public function __construct(int $ownerId, int $ownerType, int $auditStatus, string $imageID = null)
    {
        $this->ownerId = $ownerId;
        $this->ownerType = $ownerType;
        $this->auditStatus = $auditStatus;
        if(isset($imageID)) {
            $this->imageID = $imageID;
        }
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $service = ApplicationContext::getContainer()->get(QiniuAuditService::class);
        $service->dealImageWithStatus($this->auditStatus, $this->ownerId, $this->ownerType, $this->imageID);
    }
}