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
            //添加之前再次查询一下是不是有对应的图片审核信息,有的话采用更新方式
            $imageIds = [];
            collect($imageList)->map(function (string $imageUrl) use ($ownerId,$ownerType,&$imageIds) {
                $imageID = collect(explode('/', $imageUrl))->last();
                $imageIds[] = $imageID;
            });
            $auditList = ImageAudit::query()->whereIn('image_id',$imageIds)
                                            ->lockForUpdate()
                                            ->get();
            if($auditList->isEmpty()) {
                collect($imageIds)->map(function (string $imageID) use ($ownerId, $ownerType){
                    $audit = new ImageAudit();
                    $audit->image_id = $imageID;
                    $audit->owner_id = $ownerId;
                    $audit->owner_type = $ownerType;
                    $audit->user_id = $this->userId();
                    $result = $audit->save();
                    if(!$result) {
                        Log::error("图片ID($imageID)绑定实体($ownerId)($ownerType)信息失败");
                    }
                    Log::info("图片ID($imageID)绑定实体($ownerId)($ownerType)信息成功");
                });
            }else{
                $auditStatusList = $auditList->keyBy('image_id');
                collect($imageIds)->map(function (string $imageID) use ($auditStatusList,$ownerId,$ownerType){
                    if(!isset($auditStatusList[$imageID])) {
                        $audit = new ImageAudit();
                        $audit->image_id = $imageID;
                    }else{
                        $audit = ImageAudit::query()->where('image_id',$imageID)->firstOrFail();
                    }
                    $audit->owner_id = $ownerId;
                    $audit->owner_type = $ownerType;
                    $audit->user_id = $this->userId();
                    $result = $audit->save();
                    if(!$result) {
                        Log::error("图片ID($imageID)绑定实体($ownerId)($ownerType)信息失败");
                    }else{
                        Log::info("图片ID($imageID)绑定实体($ownerId)($ownerType)信息成功");
                    }
                });
            }
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

    public function auditImageOrFail(array $imageList, bool $hasReview = false)
    {
        if (empty($imageList)) {
            return [
                'need_audit' => false,
                'need_review' => false
            ];
        }

        $imageIds = $this->imageIdsFromUrlList($imageList);

        if (empty($imageIds)) {
            return [
                'need_audit' => false,
                'need_review' => false
            ];
        }

        $imageIdsLabel = implode(';',$imageIds);
        Log::info("获取图片ID:{$imageIdsLabel}进行校验审核结果");
        $imageAuditList = ImageAudit::query()->whereIn('image_id', $imageIds)
            ->get();
        if ($imageAuditList->count() != count($imageIds)) {
            Log::info("{$imageIdsLabel}图片审核结果和上传图片的个数不一致，需要进入异步审核阶段!");
            return [
                'need_audit' => true,
                'need_review' => false
            ];
        }

        $imageAuditCheck = [
            'need_audit' => false,
            'need_review' => false
        ];
        $imageAuditList->map(function (ImageAudit $audit) use (&$imageAuditCheck,$hasReview) {
            if($hasReview == false) {
                $isInvalidate = $audit->audit_status == Constants::STATUS_INVALIDATE || $audit->audit_status == Constants::STATUS_REVIEW;
            }else{
                $isInvalidate = $audit->audit_status == Constants::STATUS_INVALIDATE;
            }
            if ($isInvalidate) {
                Log::error("($audit->image_id)上传的图片未通过审核");
                throw new HyperfCommonException(ErrorCode::IMAGE_AUDIT_INVALIDATE);
            }
            //需要转人工审核确认
            if ($audit->audit_status == Constants::STATUS_REVIEW && $hasReview) {
                Log::info('图片需要人工确认审核');
                $imageAuditCheck = [
                    'need_audit' => false,
                    'need_review' => true
                ];
            }
            Log::info("{$audit->image_id}图片审核结果为通过!");
        });

        return $imageAuditCheck;
    }
}