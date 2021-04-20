<?php
/**
 * This file is part of ZYProSoft/Hyperf-Skeleton.
 *
 * @link     http://zyprosoft.lulinggushi.com
 * @document http://zyprosoft.lulinggushi.com
 * @contact  1003081775@qq.com
 * @Company  码动未来信息技术有限公司(ZYProSoft)
 * @license  GPL
 */
declare (strict_types=1);


namespace App\Service;
use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Job\AddImageAuditJob;
use App\Model\ImageAudit;
use Hyperf\DbConnection\Db;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Log\Log;
use ZYProSoft\Service\AbstractService;

class BaseService extends AbstractService
{
    public function addAuditImage(array $imageList, int $ownerId, int $ownerType)
    {
        Db::transaction(function () use ($imageList,$ownerId,$ownerType) {
            collect($imageList)->map(function (string $imageUrl) use ($ownerId,$ownerType) {
                $imageID = collect(explode('/', $imageUrl))->last();
                $audit = new ImageAudit();
                $audit->image_id = $imageID;
                $audit->owner_id = $ownerId;
                $audit->owner_type = $ownerType;
                $audit->user_id = $this->userId();
                $audit->save();
            });
        });
        Log::info("($ownerId)待审核图片添加完成!");
    }

    protected function imageIdsFromUrlList(array $imageList)
    {
        $imageIds = [];
        collect($imageList)->map(function (string $imageUrl)  use (&$imageIds) {
            $imageID = collect(explode('/', $imageUrl))->last();
            $imageIds[] = $imageID;
        });
        return $imageIds;
    }

    public function auditImageOrFail(array $imageList)
    {
        $imageIds = $this->imageIdsFromUrlList($imageList);

        if (empty($imageIds)) {
            return false;
        }

        $imageIdsLabel = implode(';',$imageIds);
        Log::info("获取图片ID:{$imageIdsLabel}进行校验审核结果");
        $imageAuditList = ImageAudit::query()->whereIn('image_id', $imageIds)
            ->get();
        if ($imageAuditList->isEmpty()) {
            Log::info("{$imageIdsLabel}不存在图片审核结果!");
            return true;
        }

        $imageAuditList->map(function (ImageAudit $audit) {
            $isInvalidate = $audit->audit_status == Constants::STATUS_INVALIDATE || $audit->audit_status == Constants::STATUS_REVIEW;
            if ($isInvalidate) {
                Log::error("($audit->image_id)上传的图片未通过审核");
                throw new HyperfCommonException(ErrorCode::IMAGE_AUDIT_INVALIDATE);
            }
            Log::info("{$audit->image_id}图片审核结果为通过!");
        });

        return false;
    }
}