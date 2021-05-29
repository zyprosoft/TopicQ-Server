<?php


namespace App\Service;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Job\UserUpdateMachineAuditJob;
use App\Model\Advice;
use App\Model\Notification;
use App\Model\PrivateMessage;
use App\Model\TokenHistory;
use App\Model\User;
use App\Model\UserAddress;
use App\Model\UserAttentionOther;
use App\Model\UserCommentPraise;
use App\Model\UserDaySign;
use App\Model\UserMiniProgramUse;
use App\Model\UserSetting;
use App\Model\UserUpdate;
use Carbon\Carbon;
use EasyWeChat\Factory;
use Hyperf\DbConnection\Db;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Facade\Auth;
use ZYProSoft\Log\Log;
use App\Service\ScoreService;
use Hyperf\Di\Annotation\Inject;

class UserService extends BaseService
{
    /**
     * @Inject
     * @var \App\Service\ScoreService
     */
    protected ScoreService $scoreService;

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
            ->with(['update_info'])
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
        $user->makeVisible('mobile');
        return $this->success($user);
    }

    public
    function getUserInfo(int $userId = null)
    {
        if (isset($userId)) {
            $user = User::findOrFail($userId);
            $user->is_attention = 0;
            //是否已经关注
            if (Auth::isGuest() == false) {
                $attention = UserAttentionOther::query()->where('user_id', $this->userId())
                    ->where('other_user_id', $userId)
                    ->first();
                if ($attention instanceof UserAttentionOther) {
                    $user->is_attention = 1;
                }
            }
            return $user;
        }
        $user = User::query()->where('user_id', $this->userId())
            ->with(['update_info'])
            ->first()
            ->makeVisible(['mobile']);
        if (!$user instanceof User) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }
        //获取个人资料的时候，检测一下更新资料ID创建是否超过时间，如果超过2分钟仍然没有完成设置为空，主动设置一下
        if (isset($user->update_info)) {
            $minutePass = Carbon::now()->diffInRealMinutes($user->update_info->created_at);
            if ($minutePass > 2) {
                Log::info("用户($user->user_id)更新资料($user->user_update_id)存在时间已经超过2分钟，现在主动清理掉!");
                $user->user_update_id = null;
                $user->save();//不影响本次结果返回
            }
        }
        //获取个人资料的时候获取一下外显的常用小程序信息
        $alwaysUseMiniProgramList = UserMiniProgramUse::query()->where('user_id', $this->userId())
            ->where('is_outside', Constants::STATUS_DONE)
            ->get()
            ->pluck('mini_program');
        $user->mini_program_list = $alwaysUseMiniProgramList;
        //获取用户设置
        $userSetting = UserSetting::query()->where('owner_id', $this->userId())->first();
        $user->user_setting = $userSetting;
        //今天是否签到
        $today = Carbon::now()->toDateString();
        $daySign = UserDaySign::query()->where('user_id',$userId)
                                       ->whereDate('sign_date',$today)
                                       ->first();
        if($daySign instanceof UserDaySign) {
            $user->day_sign = 1;
        }else{
            $user->day_sign = 0;
        }

        return $user;
    }

    public function updateUserInfo(array $userInfo)
    {
        $userUpdate = null;
        $needAddAudit = false;
        $imageList = [];
        $imageAuditCheck = [
            'need_audit' => false,
            'need_review' => false
        ];

        //创建用户资料更新的ID
        Db::transaction(function () use ($userInfo, &$userUpdate, &$needAddAudit, &$imageList, &$imageAuditCheck) {
            $user = User::findOrFail($this->userId());
            $userUpdate = new UserUpdate();
            $userUpdate->user_id = $this->userId();
            if (isset($userInfo['nickname'])) {
                $userUpdate->nickname = $userInfo['nickname'];
            }
            if (isset($userInfo['avatar'])) {
                $userUpdate->avatar = $userInfo['avatar'];
                $imageList[] = $userUpdate->avatar;
            }
            if (isset($userInfo['area'])) {
                $user->area = $userInfo['area'];
            }
            if (isset($userInfo['country'])) {
                $user->country = $userInfo['country'];
            }
            if (isset($userInfo['background'])) {
                $userUpdate->background = $userInfo['background'];
                $imageList[] = $userUpdate->background;
            }
            $user->first_edit_done = Constants::STATUS_DONE;

            //检查图片是否审核通过
            if (!empty($imageList)) {
                $imageIds = $this->imageIdsFromUrlList($imageList);
                $userUpdate->image_ids = implode(';', $imageIds);
                $imageAuditCheck = $this->auditImageOrFail($imageList);
                if ($imageAuditCheck['need_review'] == false && $imageAuditCheck['need_audit'] == false) {
                    Log::info("图片无需再审核，直接更新到用户信息上");
                    //图片都是审核通过的，那么直接更新到对应用户信息就行
                    if (isset($userInfo['avatar'])) {
                        $user->avatar = $userInfo['avatar'];
                    }
                    if (isset($userInfo['background'])) {
                        $user->background = $userInfo['background'];
                    }
                }
            }
            if ($imageAuditCheck['need_review']) {
                $userUpdate->machine_audit = Constants::STATUS_REVIEW;
            }
            $userUpdate->saveOrFail();

            //只有更新了对应的信息才需要这个更新资料的ID
            if (isset($userUpdate->nickname) || $imageAuditCheck['need_audit']) {
                $user->user_update_id = $userUpdate->update_id;
                $needAddAudit = true;
            } else {
                $user->user_update_id = null;//设置为空
                Log::info("本次无需设置信息更新ID给用户($user->user_id)");
            }

            $user->saveOrFail();
        });

        //不需要审核，直接返回成功
        if (!$needAddAudit) {
            Log::info("本次无需异步审核，直接返回!");
            return $this->success();
        }

        //需要审核，查看资料更新ID是否存在
        if (!isset($userUpdate)) {
            throw new HyperfCommonException(ErrorCode::SERVER_ERROR);
        }

        //加入用户资料异步审核任务,是否需要审核取决于更新的内容是不是包含图片和昵称,用户资料没有人工审核检测
        $this->push(new UserUpdateMachineAuditJob($userUpdate->update_id));

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
        if ($user->first_edit_done == Constants::STATUS_WAIT) {
            $registerUserInfo = config('register_user_info');
            $nicknameList = $registerUserInfo['nickname_list'];
            $randNicknameIndex = rand(0, count($nicknameList) - 1);
            $user->nickname = $nicknameList[$randNicknameIndex] . rand(0, 9);
            $avatarList = $registerUserInfo['avatar_list'];
            $backgroundList = $registerUserInfo['background_list'];
            $randAvatarIndex = rand(0, count($avatarList) - 1);
            $user->avatar = $avatarList[$randAvatarIndex];
            $randBackIndex = rand(0, count($backgroundList) - 1);
            $user->background = $backgroundList[$randBackIndex];
            $user->area = $registerUserInfo['area'];
            $user->country = $registerUserInfo['country'];
        }
        $user->makeVisible('mobile');
        $user->saveOrFail();
        return $user;
    }

    public function unreadCountInfo()
    {
        //统计回复未看的数量
        $userId = $this->userId();

        //如果是管理员，且在使用化身
        $user = User::query()->where('user_id', $userId)
            ->first();
        if (!$user instanceof User) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }
        if ($user->role_id == Constants::USER_ROLE_ADMIN) {
            if ($user->avatar_user_id > 0) {
                $userId = $user->avatar_user_id;
            }
        }

        $unreadList = Db::select("select comment_id from comment where (post_owner_id = ? or parent_comment_owner_id = ?) and comment_id not in (select comment_id from user_comment_read where user_id = ?)", [$userId, $userId, $userId]);

        //统计私信未看的数量
        $unreadMessage = PrivateMessage::query()->where('receive_id', $userId)
            ->where('read_status', Constants::STATUS_WAIT)
            ->count();

        //统计未读提醒数量
        $notificationCount = Notification::query()->where('user_id', $userId)
            ->where('is_read', Constants::STATUS_WAIT)
            ->count();

        //统计未读点赞数量
        $praiseCount = UserCommentPraise::query()->where('comment_owner_id', $userId)
            ->where('owner_read_status', Constants::STATUS_WAIT)
            ->count();

        return [
            'reply_count' => count($unreadList),
            'message_count' => $unreadMessage,
            'notification_count' => $notificationCount,
            'praise_count' => $praiseCount
        ];
    }

    public function advice(string $content)
    {
        $advice = new Advice();
        $advice->content = $content;
        $advice->owner_id = $this->userId();
        $advice->saveOrFail();
        return $this->success();
    }

    /**
     * 当前用户是不是被拉黑
     */
    public
    static function checkUserStatusOrFail()
    {
        $user = User::find(Auth::userId());
        if (!$user instanceof User) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }
        if ($user->status == Constants::STATUS_INVALIDATE) {
            throw new HyperfCommonException(ErrorCode::USER_BLOCK_BY_PLATFORM);
        }
        return $user;
    }

    public
    function addAddress(array $param)
    {
        //是否已经存在
        $address = UserAddress::query()->where('nickname', $param['nickname'])
            ->where('city', $param['city'])
            ->where('country', $param['country'])
            ->where('detail_info', $param['detailInfo'])
            ->where('phone_number', $param['phoneNumber'])
            ->first();
        if (!$address instanceof UserAddress) {
            $address = new UserAddress();
        }
        $address->nickname = $param['nickname'];
        $address->postal_code = $param['postalCode'];
        $address->province = $param['province'];
        $address->city = $param['city'];
        $address->country = $param['country'];
        $address->detail_info = $param['detailInfo'];
        if (isset($param['nationalCode'])) {
            $address->national_code = $param['nationalCode'];
        }
        $address->phone_number = $param['phoneNumber'];
        $address->owner_id = $this->userId();
        $address->save();
        return $this->success($address);
    }

    public function attention(int $otherUserId, int $status)
    {
        $attention = UserAttentionOther::query()->where('user_id', $this->userId())
            ->where('other_user_id', $otherUserId)
            ->first();
        if ($status == Constants::STATUS_DONE && $attention instanceof UserAttentionOther) {
            throw new HyperfCommonException(ErrorCode::DO_NOT_REPEAT_ACTION);
        }
        if ($status == Constants::STATUS_NOT && !$attention instanceof UserAttentionOther) {
            throw new HyperfCommonException(ErrorCode::DO_NOT_REPEAT_ACTION);
        }
        if ($status == Constants::STATUS_DONE) {
            $attention = new UserAttentionOther();
            $attention->user_id = $this->userId();
            $attention->other_user_id = $otherUserId;
            $attention->saveOrFail();
        }
        if ($status == Constants::STATUS_NOT) {
            $attention->delete();
        }
        return $this->success();
    }

    public function getUserAttentionList(int $pageIndex, int $pageSize)
    {
        $list = UserAttentionOther::query()->where('user_id', $this->userId())
            ->with(['other'])
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get()
            ->pluck('other');
        $total = UserAttentionOther::query()->where('user_id', $this->userId())->count();
        return ['total' => $total, 'list' => $list];
    }

    public function getMyFansList(int $pageIndex, int $pageSize)
    {
        $list = UserAttentionOther::query()->where('other_user_id', $this->userId())
            ->with(['owner'])
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get()
            ->pluck('owner');
        $total = UserAttentionOther::query()->where('other_user_id', $this->userId())->count();
        return ['total' => $total, 'list' => $list];
    }

    public function getOtherUserFansList(int $userId, int $pageIndex, int $pageSize)
    {
        $list = UserAttentionOther::query()->where('other_user_id', $userId)
            ->with(['owner'])
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get()
            ->pluck('owner');
        $total = UserAttentionOther::query()->where('other_user_id', $userId)->count();
        return ['total' => $total, 'list' => $list];
    }

    public function normalLogin(string $mobile, string $password)
    {
        //用户是不是已经存在
        $user = User::query()->where('mobile', $mobile)
            ->with(['update_info'])
            ->first();
        if (!$user instanceof User) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }
        $verify = password_verify($password,$user->password);
        if (!$verify) {
            throw new HyperfCommonException(ErrorCode::USER_ERROR_PASSWORD_WRONG);
        }
        //数据库token是否过期，没有过期的话直接返回Token给客户端使用，保持多端登陆一致性
        $now = Carbon::now();
        if (isset($user->token_expire) && isset($user->token)) {
            if ($now->isAfter($user->token_expire) == false) {
                Log::info("({$user->user_id})用户的Token还未失效，可以直接返回给客户端");
                return ['token' => $user->token, 'token_expire' => $user->token_expire->timestamp];
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

        return ['token' => $user->token, 'token_expire' => $user->token_expire->timestamp];
    }

    public function register(string $mobile, string $password)
    {
        $user = User::query()->where('mobile',$mobile)->first();
        if ($user instanceof User) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_DID_EXIST);
        }
        $user = new User();
        $user->mobile = $mobile;
        $user->password = password_hash($password,PASSWORD_DEFAULT);
        $user->saveOrFail();
        return $user;
    }

    public function getScoreDetailList(int $pageIndex, int $pageSize)
    {
        return $this->scoreService->getScoreDetailList($pageIndex, $pageSize);
    }

    public function daySign()
    {
        $today = Carbon::now()->toDateString();
        $sign = UserDaySign::query()->where('user_id',$this->userId())
                                         ->whereDate('sign_date',$today)
                                         ->first();
        if ($sign instanceof UserDaySign) {
            throw new HyperfCommonException(ErrorCode::DO_NOT_REPEAT_ACTION,"您今天已经签到完成了！");
        }
        $sign = new UserDaySign();
        $sign->user_id = $this->userId();
        $sign->sign_date = $today;
        $sign->saveOrFail();
        return $this->success();
    }
}