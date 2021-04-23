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

    public function getAvatarUserList(AppAdminRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->getAvatarUserList($pageIndex,$pageSize);
        return $this->success($result);
    }

    public function createAvatarUser(AppAdminRequest $request)
    {
        $this->validate(
            [
                'avatar' => 'string|required|min:1|max:500',
                'nickname' => 'string|required|min:1|max:20|sensitive',
                'background' => 'string|required|min:1|max:500',
                'area' => 'string|required|min:1|max:64',
                'country' => 'string|required|min:1|max:64'
            ]
        );
        $params = $request->getParams();
        $result = $this->service->createManagerAvatar($params);
        return $this->success($result);
    }

    public function updateAvatarUser(AppAdminRequest $request)
    {
        $this->validate(
            [
                'avatarUserId' => 'integer|required|exists:user,user_id',
                'avatar' => 'string|min:1|max:500',
                'nickname' => 'string|min:1|max:20|sensitive',
                'background' => 'string|min:1|max:500',
                'area' => 'string|min:1|max:64',
                'country' => 'string|min:1|max:64',
                'joinTime' => 'string|date',
            ]
        );
        $avatarUserId = $request->param('avatarUserId');
        $params = $request->getParams();
        $result = $this->service->updateAvatarUserInfo($avatarUserId, $params);
        return $this->success($result);
    }

    public function chooseAvatar(AppAdminRequest $request)
    {
        $this->validate(
            [
                'avatarUserId' => 'integer|required|exists:user,user_id',
            ]
        );
        $avatarUserId = $request->param('avatarUserId');
        $result = $this->service->chooseAvatarUser($avatarUserId);
        return $this->success($result);
    }

    public function unbindAvatar(AppAdminRequest $request)
    {
        $result = $this->service->unbindAvatarUser();
        return $this->success($result);
    }
}