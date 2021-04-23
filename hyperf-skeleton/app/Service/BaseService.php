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
    public function imageIdsFromUrlList(array $imageList)
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