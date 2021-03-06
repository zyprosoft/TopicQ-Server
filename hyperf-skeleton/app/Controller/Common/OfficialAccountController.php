<?php


namespace App\Controller\Common;
use App\Service\OfficialAccountService;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;

/**
 * @AutoController (prefix="/wx/official")
 * Class OfficialAccountController
 * @package App\Controller\Common
 */
class OfficialAccountController extends AbstractController
{
    /**
     * @Inject
     * @var OfficialAccountService
     */
    protected OfficialAccountService $service;

    public function notify()
    {
        $echostr = $this->request->param('echostr');
        if(isset($echostr)) {
           return $this->service->checkResponse($echostr);
        }
        $response = $this->service->receiveMessage($this->request->easyWeChatRequest());
        return $this->weChatSuccess($response->getContent());
    }

    public function authCallback()
    {

    }
}