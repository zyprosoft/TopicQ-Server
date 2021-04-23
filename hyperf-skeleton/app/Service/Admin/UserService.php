<?php


namespace App\Service\Admin;


use App\Constants\ErrorCode;
use App\Model\Advice;
use App\Model\User;
use Carbon\Carbon;
use Hyperf\Database\Model\Builder;
use ZYProSoft\Constants\ErrorCode as ZYErrorCode;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Facade\Auth;
use ZYProSoft\Log\Log;

class UserService extends \App\Service\BaseService
{
    public function login(string $username, string $password)
    {
        $user = User::query()->where('username',$username)
            ->first();
        if (!$user instanceof User) {
            throw new HyperfCommonException(ZYErrorCode::RECORD_NOT_EXIST,"用户不存在!");
        }
        $verify = password_verify($password, $user->password);
        if (!$verify) {
            throw new HyperfCommonException(ErrorCode::USER_ERROR_PASSWORD_WRONG,"密码验证错误");
        }

        $user->token = Auth::login($user);
        $now = Carbon::now();
        Log::info("token TTL :".Auth::tokenTTL());
        $expireTime = $now->addRealSeconds(Auth::tokenTTL());
        $user->token_expire = $expireTime;
        $user->last_login = $now;
        $user->saveOrFail();
        $wxExpireTime = null;
        if(isset($wxExpireTime)) {
            $wxExpireTime = $user->wx_token_expire->timestamp;
        }

        return ['token'=>$user->token,'token_expire'=>$user->token_expire->timestamp,'wx_token_expire'=>$wxExpireTime];
    }

    public function getAdviceList(int $pageIndex, int $pageSize, int $lastId = null)
    {
        $list = Advice::query()->where(function (Builder $query) use ($lastId){
            if(isset($lastId)) {
                $query->where('id','<',$lastId);
            }
        })->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->latest()
            ->get();

        $total = Advice::count();

        return ['total'=>$total,'list'=>$list];
    }

    public function createManagerAvatar(string $nickname, string $avatar, string $background)
    {
        $user = new User();
        $user->nickname = $nickname;
        $user->avatar = $avatar;
        $user->background = $background;
        $user->saveOrFail();
        return $this->success($user);
    }
}