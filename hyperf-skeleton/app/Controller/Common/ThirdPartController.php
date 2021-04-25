<?php


namespace App\Controller\Common;
use Qiniu\Auth;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\ThirdPartService;
use ZYProSoft\Http\AuthedRequest;

/**
 * @AutoController (prefix="/common/third")
 * Class ThirdPartController
 * @package App\Controller\Common
 */
class ThirdPartController extends AbstractController
{
    /**
     * @Inject
     * @var ThirdPartService
     */
    protected ThirdPartService $service;

    public function getMiniProgramAll(AuthedRequest $request)
    {
        $result = $this->service->getAllMiniProgram(true);
        return $this->success($result);
    }

    public function getOfficialAccountAll()
    {
        $result = $this->service->getAllOfficialAccount(true);
        return $this->success($result);
    }
}