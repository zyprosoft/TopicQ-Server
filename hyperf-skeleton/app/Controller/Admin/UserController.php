<?php


namespace App\Controller\Admin;
use App\Http\AppAdminRequest;
use App\Model\UserGroup;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\UserService;
use App\Service\Admin\GroupService;

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

    /**
     * @Inject
     * @var GroupService
     */
    protected GroupService $groupService;

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
                'country' => 'string|required|min:1|max:64',
                'isBind' => 'integer|required|in:0,1',
                'groupId' => 'integer|exists:user_group,group_id',
                'hobbyLabels' => 'array|min:1',
                'sex' => 'integer|in:0,1',
                'signStatus' => 'string|min:1'
            ]
        );
        $params = $request->getParams();
        $isBind = $request->param('isBind');
        $result = $this->service->createManagerAvatar($params, $isBind);
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
                'groupId' => 'integer|exists:user_group,group_id',
                'hobbyLabels' => 'array|min:1',
                'sex' => 'integer|in:0,1',
                'signStatus' => 'string|min:1'
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

    public function statistic(AppAdminRequest $request)
    {
        $result = $this->service->statistic();
        return $this->success($result);
    }

    public function searchUser(AppAdminRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
            'lastUserId' => 'integer|exists:user,user_id',
            'mobile' => 'string|min:1',
            'nickname' => 'string|min:1',
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $lastUserId = $request->param('lastUserId');
        $nickname = $request->param('nickname');
        $mobile = $request->param('mobile');
        $result = $this->service->searchUser($pageIndex,$pageSize,$lastUserId,$nickname,$mobile);
        return $this->success($result);
    }

    public function blockUser(AppAdminRequest $request)
    {
        $this->validate(
            [
                'userId' => 'integer|required|exists:user,user_id',
                'status' => 'integer|required|in:0,-1'
            ]
        );
        $userId = $request->param('userId');
        $status = $request->param('status');
        $result = $this->service->updateUserStatus($userId,$status);
        return $this->success($result);
    }

    public function getUserRoleList(AppAdminRequest $request)
    {
        $result = $this->service->getUserRoleList();
        return $this->success($result);
    }

    public function setUserRole(AppAdminRequest $request)
    {
        $this->validate(
            [
                'userId' => 'integer|required|exists:user,user_id',
                'roleId' => 'integer|required'
            ]
        );
        $userId = $request->param('userId');
        $roleId = $request->param('roleId');
        $result = $this->service->setUserRole($userId,$roleId);
        return $this->success($result);
    }

    public function getUserGroupList(AppAdminRequest $request)
    {
        $result = $this->groupService->list();
        return $this->success($result);
    }

    public function createGroup(AppAdminRequest $request)
    {
        $this->validate([
            'name' => 'string|required|min:1|max:24',
            'openChoose' => 'integer|in:0,1',
            'needRealName' => 'integer|in:0,1',
            'labelColor' => 'string|min:1',
            'groupId' => 'integer|exists:user_group,group_id'
        ]);
        $params = $request->getParams();
        $groupId = $request->param('groupId');
        $result = $this->groupService->createOrUpdate($params,$groupId);
        return $this->success($result);
    }

    public function setUserGroup(AppAdminRequest $request)
    {
        $this->validate([
            'mobile' => 'string|required|min:11|max:11',
            'groupId' => 'integer|required|exists:user_group,group_id'
        ]);
        $mobile = $request->param('mobile');
        $groupId = $request->param('groupId');
        $result = $this->groupService->setUserGroup($mobile,$groupId);
        return $this->success($result);
    }

    public function getUnreadCountInfo()
    {
        $result = $this->service->getUnreadCountInfo();
        return $this->success($result);
    }
}