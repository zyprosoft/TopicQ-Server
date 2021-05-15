<?php


namespace App\Controller\Common;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\AppSettingService;

/**
 * @AutoController (prefix="/app/setting")
 * Class AppSettingController
 * @package App\Controller\Common
 */
class AppSettingController extends AbstractController
{
    /**
     * @Inject
     * @var AppSettingService
     */
    protected AppSettingService $service;

    public function info()
    {
        $result = $this->service->getSettingInfo();
        return $this->success($result);
    }
}