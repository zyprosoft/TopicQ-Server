<?php


namespace App\Controller\Admin;
use App\Http\AppAdminRequest;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\ThirdPartService;
use App\Service\Admin\ForumService;

/**
 * @AutoController (prefix="/admin/third")
 * Class ThirdPartController
 * @package App\Controller\Admin
 */
class ThirdPartController extends AbstractController
{
    /**
     * @Inject
     * @var ThirdPartService
     */
    private ThirdPartService $service;

    public function getMiniProgramCategoryList(AppAdminRequest $request)
    {
        $result = $this->service->getMiniProgramCategoryList();
        return $this->success($result);
    }

    public function getOfficialAccountCategoryList(AppAdminRequest $request)
    {
        $result = $this->service->getOfficialAccountCategoryList();
        return $this->success($result);
    }

    public function getMiniProgram(AppAdminRequest $request)
    {
        $this->validate([
            'programId' => 'integer|required|exists:mini_program,program_id',
        ]);
        $programId = $request->param('programId');
        $result = $this->service->getMiniProgram($programId);
        return $this->success($result);
    }

    public function getOfficialAccount(AppAdminRequest $request)
    {
        $this->validate([
            'accountId' => 'integer|required|exists:official_account,account_id',
        ]);
        $accountId = $request->param('accountId');
        $result = $this->service->getOfficialAccount($accountId);
        return $this->success($result);
    }

    public function createMiniProgram(AppAdminRequest $request)
    {
        $this->validate([
            'name'=> 'string|required|min:1|max:24',
            'shortName' => 'string|required|min:1|max:12',
            'icon' => 'string|required|min:1|max:500',
            'introduce' => 'string|required|min:1|max:500',
            'appId' => 'string|required|min:1|max:64',
            'indexPath' => 'string|min:1|max:64',
            'categoryId' => 'integer|required|exists:mini_program_category,category_id'
        ]);
        $name = $request->param('name');
        $shortName = $request->param('shortName');
        $icon = $request->param('icon');
        $introduce = $request->param('introduce');
        $categoryId = $request->param('categoryId');
        $appId = $request->param('appId');
        $result = $this->service->addMiniProgram($categoryId,$appId,$shortName,$name,$icon,$introduce);
        return $this->success($result);
    }

    public function editMiniProgram(AppAdminRequest $request)
    {
        $this->validate([
            'programId' => 'integer|required|exists:mini_program,program_id',
            'name'=> 'string|min:1|max:24',
            'shortName' => 'string|min:1|max:12',
            'icon' => 'string|min:1|max:500',
            'introduce' => 'string|min:1|max:500',
            'appId' => 'string|min:1|max:64',
            'indexPath' => 'string|min:1|max:64',
            'categoryId' => 'integer|exists:mini_program_category,category_id'
        ]);
        $programId = $request->param('programId');
        $name = $request->param('name');
        $shortName = $request->param('shortName');
        $icon = $request->param('icon');
        $introduce = $request->param('introduce');
        $categoryId = $request->param('categoryId');
        $appId = $request->param('appId');
        $result = $this->service->editMiniProgram($programId,$categoryId,$appId,$shortName,$name,$icon,$introduce);
        return $this->success($result);
    }

    public function createOfficialAccount(AppAdminRequest $request)
    {
        $this->validate([
            'name'=> 'string|required|min:1|max:24',
            'icon' => 'string|required|min:1|max:500',
            'introduce' => 'string|required|min:1|max:500',
            'wechatId' => 'string|required|min:1|max:64',
            'categoryId' => 'integer|required|exists:official_account_category,category_id'
        ]);
        $name = $request->param('name');
        $icon = $request->param('icon');
        $introduce = $request->param('introduce');
        $categoryId = $request->param('categoryId');
        $wechatId = $request->param('wechatId');
        $result = $this->service->addOfficialAccount($categoryId,$wechatId,$name,$icon,$introduce);
        return $this->success($result);
    }

    public function editOfficialAccount(AppAdminRequest $request)
    {
        $this->validate([
            'accountId' => 'integer|required|exists:official_account,account_id',
            'name'=> 'string|min:1|max:24',
            'icon' => 'string|min:1|max:500',
            'introduce' => 'string|min:1|max:500',
            'wechatId' => 'string|min:1|max:64',
            'categoryId' => 'integer|exists:official_account_category,category_id'
        ]);
        $name = $request->param('name');
        $icon = $request->param('icon');
        $introduce = $request->param('introduce');
        $categoryId = $request->param('categoryId');
        $wechatId = $request->param('wechatId');
        $accountId = $request->param('accountId');
        $result = $this->service->editOfficialAccount($accountId,$categoryId,$wechatId,$name,$icon,$introduce);
        return $this->success($result);
    }
}