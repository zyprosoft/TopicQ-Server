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
        $result = $this->userService->refreshToken($this->request->getToken());
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
                'country' => 'string|min:1|max:64'
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
}