<?php


namespace App\Service;
use Carbon\Carbon;
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
        
    }
}