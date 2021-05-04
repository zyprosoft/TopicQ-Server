<?php


namespace App\Controller\Common;
use Qiniu\Auth;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\PddService;
use ZYProSoft\Http\AuthedRequest;

/**
 * @AutoController (prefix="/common/mall")
 * Class MallController
 * @package App\Controller\Common
 */
class MallController extends AbstractController
{
    /**
     * @Inject
     * @var PddService
     */
    protected PddService $pddService;

    public function generatePddApplyUrl(AuthedRequest $request)
    {
        $result = $this->pddService->generatePidAuthUrl();
        return $this->success($result);
    }

    public function queryPddPidAuthStatus(AuthedRequest $request)
    {
        $result = $this->pddService->queryPidAuthStatus();
        return $this->success($result);
    }
}