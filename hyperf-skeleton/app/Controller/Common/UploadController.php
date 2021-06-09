<?php


namespace App\Controller\Common;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\UploadService;
use ZYProSoft\Http\AuthedRequest;

/**
 * @AutoController (prefix="/common/attactment")
 * Class UploadController
 * @package App\Controller\Common
 */
class UploadController extends AbstractController
{
    /**
     * @Inject
     * @var UploadService
     */
    protected UploadService $service;

    /**
     * 获取七牛对象存储的图片上传Token
     * 获取的Token只能用于上传图片类型的文件
     * @param AuthedRequest $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getUploadImageToken(AuthedRequest $request)
    {
        $this->validate([
            'fileKey' => 'string|required|min:1'
        ]);
        $fileKey = $request->param('fileKey');
        $result = $this->service->getImageUploadToken($fileKey);
        return $this->success($result);
    }

    /**
     * 获取七牛对象存储的通用文件的上传Token
     * @param AuthedRequest $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getUploadToken(AuthedRequest $request)
    {
        $this->validate([
            'fileKey' => 'string|required|min:1'
        ]);
        $fileKey = $request->param('fileKey');
        $result = $this->service->getCommonUploadToken($fileKey);
        return $this->success($result);
    }
}