<?php


namespace App\Controller\Admin;
use App\Http\AppAdminRequest;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\UserService;

/**
 * @AutoController (prefix="/admin/user")
 * Class UserController
 * @package App\Controller\Admin
 */
class UserController extends AbstractController
{
    /**
     * @Inject
     * @var UserService
     */
    private UserService $service;

    public function login()
    {
        $this->validate([
            'username' => 'string|min:1|required',
            'password' => 'string|min:1|required'
        ]);
        $username = $this->request->param('username');
        $password = $this->request->param('password');
        $result = $this->service->login($username, $password);
        return $this->success($result);
    }

    public function adviceList(AppAdminRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
            'lastId' => 'integer|min:1'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $lastId = $request->param('lastId');
        $result = $this->service->getAdviceList($pageIndex, $pageSize, $lastId);
        return $this->success($result);
    }
}