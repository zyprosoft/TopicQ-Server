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
        $this->validate([
            'type' => 'string|in:weixin,qq',
        ]);
        $type = $request->param('type');
        $result = $this->service->getAllMiniProgram(true,$type);
        return $this->success($result);
    }

    public function getOfficialAccountAll(AuthedRequest $request)
    {
        $result = $this->service->getAllOfficialAccount(true);
        return $this->success($result);
    }

    public function markMiniProgramUse(AuthedRequest $request)
    {
        $this->validate([
            'type' => 'string|in:weixin,qq',
            'programId' => 'integer|required|exists:mini_program,program_id'
        ]);
        $type = $request->param('type');
        $programId = $request->param('programId');
        $result = $this->service->markMiniProgramUsed($programId,$type);
        return $this->success($result);
    }

    public function markOfficialAccountUse(AuthedRequest $request)
    {
        $this->validate([
            'accountId' => 'integer|required|exists:official_account,account_id'
        ]);
        $programId = $request->param('accountId');
        $result = $this->service->markOfficialAccountUse($programId);
        return $this->success($result);
    }

    public function markMiniProgramOutside(AuthedRequest $request)
    {
        $this->validate([
            'type' => 'string|in:weixin,qq',
            'programId' => 'integer|required|exists:mini_program,program_id'
        ]);
        $type = $request->param('type');
        $programId = $request->param('programId');
        $result = $this->service->markMiniProgramOutside($programId,$type);
        return $this->success($result);
    }

    public function unbindMiniProgramOutside(AuthedRequest $request)
    {
        $this->validate([
            'type' => 'string|in:weixin,qq',
            'programId' => 'integer|required|exists:mini_program,program_id'
        ]);
        $type = $request->param('type');
        $programId = $request->param('programId');
        $result = $this->service->unbindMiniProgramOutside($programId,$type);
        return $this->success($result);
    }

    public function getAlwaysUsedMiniProgramList(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
            'type' => 'string|in:weixin,qq',
        ]);
        $type = $request->param('type');
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $result = $this->service->getUserMiniProgramAlwaysUseList($pageIndex, $pageSize, $type);
        return $this->success($result);
    }

    public function getUsedMiniProgramList(AuthedRequest $request)
    {
        $this->validate([
            'type' => 'string|in:weixin,qq',
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
        ]);
        $type = $request->param('type');
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $result = $this->service->getUserMiniProgramUseList($pageIndex, $pageSize, $type);
        return $this->success($result);
    }
}