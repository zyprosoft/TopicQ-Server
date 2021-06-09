<?php


namespace App\Service;
use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Job\AddUserUploadStatisticJob;
use App\Model\UserUploadStatistic;
use Carbon\Carbon;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Service\UploadService as CoreUploadService;
use Hyperf\Di\Annotation\Inject;

class UploadService extends BaseService
{
    /**
     * @Inject
     * @var CoreUploadService
     */
    protected CoreUploadService $uploadService;

    public function getImageUploadToken(string $fileKey)
    {
        $policy = [
            'insertOnly' => 1,
            'mimeLimit' => 'image/*',
        ];
        return $this->getCommonUploadToken($fileKey, $policy);
    }

    public function getCommonUploadToken(string $fileKey, array $policy = null)
    {
        //检查用户是不是
        $today = Carbon::today()->toDateString();
        $statistic = UserUploadStatistic::query()->where('owner_id',$this->userId())
                                                 ->whereDate('upload_date',$today)
                                                 ->first();
        if ($statistic instanceof UserUploadStatistic) {
            //检查一下是不是受限制了今天
            if ($statistic->disable == Constants::STATUS_OK) {
                throw new HyperfCommonException(ErrorCode::PLATFORM_DISABLE_USER_UPLOAD);
            }
        }

        //正常获取
        $result = $this->uploadService->getQiniuCommonUploadToken($fileKey,$policy);

        //异步记录用户上传次数
        $this->push(new AddUserUploadStatisticJob($this->userId(),$today));

        return $result;
    }
}