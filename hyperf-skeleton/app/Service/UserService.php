<?php


namespace App\Service;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Model\Comment;
use App\Model\PrivateMessage;
use App\Model\TokenHistory;
use App\Model\User;
use Carbon\Carbon;
use EasyWeChat\Factory;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Facade\Auth;
use ZYProSoft\Log\Log;

class UserService extends BaseService
{
    public function wxLogin(string $code)
    {
        $miniProgramConfig = config('weixin.miniProgram');
        Log::info('min program config:' . json_encode($miniProgramConfig));
        $app = Factory::miniProgram($miniProgramConfig);
        $session = $app->auth->session($code);
        //保存授权信息
        Log::info("tmp code:$code wx session info:" . json_encode($session));
        $openid = $session['openid'];
        $sessionKey = $session['session_key'];

        //用户是不是已经存在
        $user = User::query()->where('wx_openid', $openid)
            ->first();
        if (!$user instanceof User) {
            $user = new User();
            $user->wx_openid = $openid;
            $user->wx_token = $sessionKey;
        } else {
            $user->wx_token = $sessionKey;
        }
        //数据库token是否过期，没有过期的话直接返回Token给客户端使用，保持多端登陆一致性
        $now = Carbon::now();
        if (isset($user->token_expire) && isset($user->token) && isset($user->wx_token) && isset($user->wx_token_expire)) {
            if ($now->isAfter($user->token_expire) == false && $now->isAfter($user->wx_token_expire) == false) {
                Log::info("({$user->user_id})用户的Token还未失效，可以直接返回给客户端");
                //更新微信Token过期时间，返回普通Token给客户端
                $wxExpireTime = Carbon::now()->addRealSeconds(Constants::WX_TOKEN_TTL);
                $user->wx_token_expire = $wxExpireTime;
                $user->last_login = Carbon::now();
                $user->saveOrFail();
                return ['token' => $user->token, 'token_expire' => $user->token_expire->timestamp, 'wx_token_expire' => $user->wx_token_expire->timestamp];
            } else {
                //需要重新登陆，保存历史Token
                $tokenHistory = new TokenHistory();
                $tokenHistory->owner_id = $user->user_id;
                $tokenHistory->token = $user->token;
                $tokenHistory->token_expire = $user->token_expire->toDateTimeString();
                $tokenHistory->saveOrFail();
                Log::info("({$user->user_id})用户token已经过期,保存历史Token");
            }
        }

        //Auth的token过期时间单位是秒
        $wxExpireTime = Carbon::now()->addRealSeconds(Constants::WX_TOKEN_TTL);
        $user->wx_token_expire = $wxExpireTime;
        //不能使用之前的那个会导致时间变长
        $expireTime = Carbon::now()->addRealSeconds(Auth::tokenTTL());
        $user->token_expire = $expireTime;
        $user->last_login = Carbon::now();
        $user->saveOrFail();
        //需要先获取UserId，然后才能用Token登陆
        $token = $this->auth->login($user);
        //然后再保存一次Token
        $user->token = $token;
        $user->saveOrFail();

        return ['token' => $user->token, 'token_expire' => $user->token_expire->timestamp, 'wx_token_expire' => $user->wx_token_expire->timestamp];
    }

    public function refreshToken(string $token)
    {
        $user = User::query()->where('token', $token)->first();
        if (!$user instanceof User) {
            //是不是用了历史用过的Token来刷新
            $tokenHistory = TokenHistory::query()->where('token', $token)->first();
            if ($tokenHistory instanceof TokenHistory) {
                Log::info("刷新Token使用了历史用过的的Token,允许直接返回当前用户的有效Token给客户端");
                $user = User::find($tokenHistory->owner_id);
                if (!$user instanceof User) {
                    throw new HyperfCommonException(ErrorCode::USER_REFRESH_TOKEN_INVALIDATE);
                }
                //用户登陆信息都还在并且有效
                if (isset($user->token_expire) && isset($user->token) && isset($user->wx_token) && isset($user->wx_token_expire)) {
                    if (Carbon::now()->isAfter($user->token_expire) == false && Carbon::now()->isAfter($user->wx_token_expire) == false) {
                        Log::info("刷新Token时({$user->user_id})用户的Token还未失效，可以直接返回给客户端");
                        //更新微信Token过期时间，返回普通Token给客户端
                        $wxExpireTime = Carbon::now()->addRealSeconds(Constants::WX_TOKEN_TTL);
                        $user->wx_token_expire = $wxExpireTime;
                        $user->last_login = Carbon::now();
                        $user->saveOrFail();
                        return ['token' => $user->token, 'token_expire' => $user->token_expire->timestamp, 'wx_token_expire' => $user->wx_token_expire->timestamp];
                    }
                }
            } else {
                //历史都没用过这个Token肯定是非法的
                throw new HyperfCommonException(ErrorCode::USER_REFRESH_TOKEN_INVALIDATE);
            }
        }

        //保存历史使用过的Token
        $tokenHistory = new TokenHistory();
        $tokenHistory->owner_id = $user->user_id;
        $tokenHistory->token = $user->token;
        $tokenHistory->token_expire = $user->token_expire->toDateTimeString();
        $tokenHistory->saveOrFail();
        Log::info("({$user->user_id})用户token已经过期开始刷新,保存历史Token");

        $now = Carbon::now();
        $expireTime = $now->addRealSeconds(Auth::tokenTTL());
        $newToken = $this->auth->login($user);
        $user->token = $newToken;
        $user->token_expire = $expireTime;
        $user->last_login = Carbon::now();
        $user->saveOrFail();
        $wxExpireTime = null;
        if (isset($user->wx_token_expire)) {
            $wxExpireTime = $user->wx_token_expire->timestamp;
        }

        return ['token' => $user->token, 'token_expire' => $user->token_expire->timestamp, 'wx_token_expire' => $wxExpireTime];
    }

    public
    function updateWxUserInfo(array $userInfo)
    {
        $user = User::findOrFail($this->userId());
        $user->nickname = $userInfo['nickName'];
        $user->avatar = $userInfo['avatarUrl'];
        $user->wx_gender = $userInfo['gender'];
        $user->wx_city = $userInfo['city'];
        $user->wx_country = $userInfo['country'];
        $user->wx_province = $userInfo['province'];
        $user->last_login = Carbon::now();
        $user->first_edit_done = Constants::STATUS_DONE;
        $user->saveOrFail();
        return $this->success($user);
    }

    public
    function getUserInfo(int $userId = null)
    {
        if (isset($userId)) {
            return User::findOrFail($userId);
        }
        return User::findOrFail($this->userId());
    }

    public function updateUserInfo(array $userInfo)
    {
        $user = User::findOrFail($this->userId());
        if (isset($userInfo['nickname'])) {
            $user->nickname = $userInfo['nickname'];
        }
        if (isset($userInfo['avatar'])) {
            $user->avatar = $userInfo['avatar'];
        }
        if (isset($userInfo['area'])) {
            $user->area = $userInfo['area'];
        }
        if (isset($userInfo['country'])) {
            $user->country = $userInfo['country'];
        }
        if (isset($userInfo['background'])) {
            $user->background = $userInfo['background'];
        }
        $user->first_edit_done = Constants::STATUS_DONE;
        $user->saveOrFail();
        return $this->success();
    }

    public
    function decryptPhoneNumber(string $iv, string $encryptData)
    {
        $user = User::findOrFail($this->userId());
        $miniProgramConfig = config('weixin.miniProgram');
        $app = Factory::miniProgram($miniProgramConfig);
        $result = $app->encryptor->decryptData($user->wx_token, $iv, $encryptData);
        $phoneNumber = $result['purePhoneNumber'];
        $user->mobile = $phoneNumber;
        if($user->first_edit_done == Constants::STATUS_WAIT) {
            $registerUserInfo = config('register_user_info');
            $nicknameList = $registerUserInfo['nickname_list'];
            $randNicknameIndex = rand(0,count($nicknameList)-1);
            $user->nickname = $nicknameList[$randNicknameIndex].rand(0,9);
            $avatarList = $registerUserInfo['avatar_list'];
            $backgroundList = $registerUserInfo['background_list'];
            $randAvatarIndex = rand(0,count($avatarList)-1);
            $user->avatar = $avatarList[$randAvatarIndex];
            $randBackIndex = rand(0,count($backgroundList)-1);
            $user->background = $backgroundList[$randBackIndex];
        }
        $user->saveOrFail();
        return $user;
    }

    public function unreadCountInfo()
    {
        //统计回复未看的数量
        $unreadReply = Comment::query()->select(['comment.comment_id','owner_id','user_id'])
            ->leftJoin('user_comment_read','comment_id','=','comment_id')
            ->where('owner_id', $this->userId())
            ->orWhere('post_owner_id', $this->userId())
            ->whereNull('user_id')
            ->count();
        //统计私信未看的数量
        $unreadMessage = PrivateMessage::query()->where('receive_id', $this->userId())
                                                ->where('read_status',Constants::STATUS_WAIT)
                                                ->count();
        return [
            'reply_count' => $unreadReply,
            'message_count' => $unreadMessage
        ];
    }
}