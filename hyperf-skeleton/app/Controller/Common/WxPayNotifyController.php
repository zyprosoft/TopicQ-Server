<?php


namespace App\Controller\Common;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\WxPayService;

/**
 * @AutoController (prefix="/wxpay")
 * Class WxPayNotifyController
 * @package App\Controller\Common
 */
class WxPayNotifyController extends AbstractController
{
    /**
     * @Inject
     * @var WxPayService
     */
    private WxPayService $service;

    public function receiveNotify()
    {
        $response = $this->service->handle($this->request->easyWeChatRequest());
        return $this->weChatSuccess($response->getContent());
    }
}