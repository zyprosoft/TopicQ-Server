<?php


namespace App\Controller\Common;
use Qiniu\Auth;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\UserService;
use ZYProSoft\Http\AuthedRequest;

/**
 * @AutoController (prefix="/common/user")
 * Class UserController
 * @package App\Controller\Common
 */
class UserController extends AbstractController
{
    /**
     * @Inject
     * @var UserService
     */
    private UserService $userService;

    /**
     * 小程序微信登陆
     */
    public function login()
    {
        $this->validate([
            'code' => 'string|min:1|required'
        ]);
        $code = $this->request->param('code');
        $result = $this->userService->wxLogin($code);
        return $this->success($result);
    }

    public function qqLogin()
    {
        $this->validate([
            'code' => 'string|min:1|required'
        ]);
        $code = $this->request->param('code');
        $result = $this->userService->qqLogin($code);
        return $this->success($result);
    }

    public function baiduLogin()
    {
        $this->validate([
            'code' => 'string|min:1|required',
            'mobile' => 'string|required|min:11|max:11'
        ]);
        $code = $this->request->param('code');
        $mobile = $this->request->param('mobile');
        $result = $this->userService->baiduLogin($code,$mobile);
        return $this->success($result);
    }

    //只能在qq、百度、抖音里面请求
    public function miniSendLoginSms(AuthedRequest $request)
    {
        $this->validate([
            'mobile' => 'string|min:11|max:11|required'
        ]);
        $mobile = $request->param('mobile');
        $result = $this->userService->sendLoginSms($mobile);
        return $this->success($result);
    }

    //只能在qq、百度、抖音里面请求
    public function miniSmsLogin(AuthedRequest $request)
    {
        $this->validate([
            'code' => 'string|required|min:5|max:5',
            'mobile' => 'string|required|min:11|max:11',
            'type' => 'string|in:qq,baidu,byte'
        ]);
        $code = $request->param('code');
        $mobile = $request->param('mobile');
        $type = $request->param('type');
        $result = $this->userService->smsLogin($mobile,$code,$type);
        return $this->success($result);
    }

    public function normalLogin()
    {
        $this->validate([
            'mobile' => 'numeric|min:11|max:11|required|exists:user,mobile',
            'password' => 'string|min:6|max:12|required'
        ]);
        $mobile = $this->request->param('mobile');
        $password = $this->request->param('password');
        $result = $this->userService->normalLogin($mobile,$password);
        return $this->success($result);
    }

    public function register()
    {
        $this->validate([
            'mobile' => 'string|min:11|max:11|required',
            'password' => 'string|min:6|max:12|required'
        ]);
        $mobile = $this->request->param('mobile');
        $password = $this->request->param('password');
        $result = $this->userService->register($mobile,$password);
        return $this->success($result);
    }

    public function getUserInfo(AuthedRequest $request)
    {
        $result = $this->userService->getUserInfo();
        return $this->success($result);
    }

    public function getOtherUserInfo()
    {
        $this->validate([
            'userId' => 'integer|required|exists:user,user_id',
        ]);
        $userId = $this->request->param('userId');
        $result = $this->userService->getUserInfo($userId);
        return $this->success($result);
    }

    public function refreshToken()
    {
        $this->validate([
            'type' => 'string|in:weixin,qq,baidu,byte',
        ]);
        $type = $this->request->param('type');
        $result = $this->userService->refreshToken($this->request->getToken(),$type);
        return $this->success($result);
    }

    public function updateUserInfo(AuthedRequest $request)
    {
        $this->validate(
            [
                'avatar' => 'string|min:1|max:500',
                'nickname' => 'string|min:1|max:20|sensitive',
                'background' => 'string|min:1|max:500',
                'area' => 'string|min:1|max:64',
                'country' => 'string|min:1|max:64',
                'groupId' => 'integer|min:0'  //可以为0，用于清除自己的用户分组
            ]
        );
        $params = $request->getParams();
        $result = $this->userService->updateUserInfo($params);
        return $this->success($result);
    }

    public function updateWxUserInfo(AuthedRequest $request)
    {
        $this->validate([
            'nickName' => 'string|min:1',
            'avatarUrl' => 'string|min:1',
            'country' => 'string|min:1',
            'province' => 'string|min:1',
            'city' => 'string|min:1',
            'gender' => 'int|min:0',
        ]);
        $params = $request->getParams();
        $result = $this->userService->updateWxUserInfo($params);
        return $this->success($result);
    }

    public function decryptPhoneNumber(AuthedRequest $request)
    {
        $this->validate([
            'iv' => 'string|min:1|required',
            'encryptData' => 'string|min:1|required',
        ]);
        $iv = $request->param('iv');
        $encryptData = $request->param('encryptData');
        $result = $this->userService->decryptPhoneNumber($iv,$encryptData);
        return $this->success($result);
    }

    public function unreadCountInfo(AuthedRequest $request)
    {
        $result = $this->userService->unreadCountInfo();
        return $this->success($result);
    }

    public function advice(AuthedRequest $request)
    {
        $this->validate([
            'content' => 'string|min:1|required',
        ]);
        $content = $request->param('content');
        $result = $this->userService->advice($content);
        return $this->success($result);
    }

    public function addAddress(AuthedRequest $request)
    {
        $this->validate([
            'nickname' => 'string|required|min:1|max:20',
            'postalCode' => 'digits:6|required',
            'province' => 'string|required|min:1|max:30',
            'city' => 'string|required|min:1|max:50',
            'country' => 'string|required|min:1|max:50',
            'detailInfo' => 'string|required|min:1|max:128',
            'nationalCode' => 'string|min:1|max:20',
            'phoneNumber'=> 'string|required|min:1|max:20'
        ]);
        $result = $this->userService->addAddress($request->getParams());
        return $this->success($result);
    }

    public function attention(AuthedRequest $request)
    {
        $this->validate([
            'otherUserId'=>'integer|required|exists:user,user_id',
            'status'=>'integer|required|in:0,1'
        ]);
        $otherUserId = $request->param('otherUserId');
        $status = $request->param('status');
        $result = $this->userService->attention($otherUserId,$status);
        return $this->success($result);
    }

    public function getUserAttentionList(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
        ]);
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $result = $this->userService->getUserAttentionList($pageIndex,$pageSize);
        return $this->success($result);
    }

    public function getMyFansList(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
        ]);
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $result = $this->userService->getMyFansList($pageIndex,$pageSize);
        return $this->success($result);
    }

    public function getOtherUserFansList(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
            'otherUserId' => 'integer|required|exists:user,user_id'
        ]);
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $otherUserId = $request->param('otherUserId');
        $result = $this->userService->getOtherUserFansList($otherUserId, $pageIndex, $pageSize);
        return $this->success($result);
    }

    public function getUserScoreDetail(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->userService->getScoreDetailList($pageIndex,$pageSize);
        return $this->success($result);
    }

    public function daySign(AuthedRequest $request)
    {
        $result = $this->userService->daySign();
        return $this->success($result);
    }

    public function getUserGroupList(AuthedRequest $request)
    {
        $result = $this->userService->getUserGroupList();
        return $this->success($result);
    }

    public function getUserListByScore()
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30'
        ]);
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $result = $this->userService->getUserListByScore($pageIndex,$pageSize);
        return $this->success($result);
    }

    public function getHobbyLabels()
    {
        $result = $this->userService->getAllHobbyLabels();
        return $this->success($result);
    }
}