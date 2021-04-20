<?php


namespace App\Job;
use App\Model\ImageAudit;
use Hyperf\AsyncQueue\Job;
use Hyperf\DbConnection\Db;
use ZYProSoft\Log\Log;

class AddImageAuditJob extends Job
{
    public array $imageList;

    public int $ownerId;

    public int $ownerType;

    public int $userId;

    public function __construct(array $imageList, int $ownerId, int $ownerType, int $userId)
    {
        $this->imageList = $imageList;
        $this->ownerId = $ownerId;
        $this->ownerType = $ownerType;
        $this->userId = $userId;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        if (empty($this->imageList)) {
            return;
        }

        Log::info("开始异步添加图片审核预备信息");
        Db::transaction(function () {
            collect($this->imageList)->map(function (string $imageUrl) {
                $imageID = collect(explode('/', $imageUrl))->last();
                $audit = new ImageAudit();
                $audit->image_id = $imageID;
                $audit->owner_id = $this->ownerId;
                $audit->owner_type = $this->ownerType;
                $audit->user_id = $this->userId;
                $audit->saveOrFail();
            });
        });

        Log::info("异步保存图片待审核信息成功:".json_encode($this->imageList));
    }
}