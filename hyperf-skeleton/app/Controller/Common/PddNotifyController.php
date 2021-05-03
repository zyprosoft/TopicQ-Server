<?php


namespace App\Controller\Common;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\PddService;
use ZYProSoft\Log\Log;

/**
 * @AutoController (prefix="/pdd")
 * Class PddNotifyController
 * @package App\Controller\Common
 */
class PddNotifyController extends AbstractController
{
    /**
     * @Inject
     * @var PddService
     */
    protected PddService $service;

    public function notify()
    {
        Log::info("pdd notify:".$this->request->getBody());
    }
}