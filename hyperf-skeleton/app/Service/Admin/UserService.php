<?php


namespace App\Service\Admin;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Model\Advice;
use App\Model\Comment;
use App\Model\ManagerAvatarUser;
use App\Model\Post;
use App\Model\PrivateMessage;
use App\Model\User;
use Carbon\Carbon;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;
use Hyperf\Utils\Str;
use ZYProSoft\Constants\ErrorCode as ZYErrorCode;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Facade\Auth;
use ZYProSoft\Log\Log;

class UserService extends \App\Service\BaseService
{
    public function login(string $username, string $password)
    {
        $user = User::query()->where('username', $username)
            ->first();
        if (!$user instanceof User) {
            throw new HyperfCommonException(ZYErrorCode::RECORD_NOT_EXIST, "用户不存在!");
        }
        $verify = password_verify($password, $user->password);
        if (!$verify) {
            throw new HyperfCommonException(ErrorCode::USER_ERROR_PASSWORD_WRONG, "密码验证错误");
        }

        $user->token = Auth::login($user);
        $now = Carbon::now();
        Log::info("token TTL :" . Auth::tokenTTL());
        $expireTime = $now->addRealSeconds(Auth::tokenTTL());
        $user->token_expire = $expireTime;
        $user->last_login = $now;
        $user->saveOrFail();
        $wxExpireTime = null;
        if (isset($wxExpireTime)) {
            $wxExpireTime = $user->wx_token_expire->timestamp;
        }

        return ['token' => $user->token, 'token_expire' => $user->token_expire->timestamp, 'wx_token_expire' => $wxExpireTime];
    }

    public function getAdviceList(int $pageIndex, int $pageSize, int $lastId = null)
    {
        $list = Advice::query()->where(function (Builder $query) use ($lastId) {
            if (isset($lastId)) {
                $query->where('id', '<', $lastId);
            }
        })->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->latest()
            ->get();

        $total = Advice::count();

        return ['total' => $total, 'list' => $list];
    }

    public function updateAvatarUserInfo(int $avatarUserId, array $params)
    {
        $user = User::find($avatarUserId);
        if (!$user instanceof User) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }
        $user->nickname = data_get($params, 'nickname', $user->nickname);
        $user->avatar = data_get($params, 'avatar', $user->avatar);
        $user->background = data_get($params, 'background', $user->background);
        $user->area = data_get($params, 'area', $user->area);
        $user->country = data_get($params, 'country', $user->country);
        $joinTime = data_get($params, 'joinTime');
        if (isset($joinTime)) {
            $user->created_at = $joinTime;
        }
        $user->saveOrFail();
    }

    public function createManagerAvatar(array $params, int $isBindNow = 0)
    {
        Db::transaction(function () use ($params, $isBindNow) {

            $manager = User::query()->where('user_id', $this->userId())
                ->first();
            if (!$manager instanceof User) {
                throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
            }

            $user = new User();
            $user->nickname = data_get($params, 'nickname');
            $user->avatar = data_get($params, 'avatar');
            $user->background = data_get($params, 'background');
            $user->area = data_get($params, 'area');
            $user->country = data_get($params, 'country');
            $user->token = Str::random(64);
            $user->wx_token = Str::random(64);
            $user->wx_openid = Str::random(64);
            $user->saveOrFail();

            $managerAvatarUser = new ManagerAvatarUser();
            $managerAvatarUser->avatar_user_id = $user->user_id;
            $managerAvatarUser->owner_id = $manager->user_id;
            $managerAvatarUser->saveOrFail();

            if ($isBindNow == 1) {
                $manager->avatar_user_id = $user->user_id;
                $manager->saveOrFail();
            }

        });

        return $this->success();
    }

    public function chooseAvatarUser(int $avatarUserId)
    {
        $manager = User::query()->where('user_id', $this->userId())
            ->first();
        if (!$manager instanceof User) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }
        $manager->avatar_user_id = $avatarUserId;
        $manager->saveOrFail();
        return $this->success();
    }

    public function unbindAvatarUser()
    {
        $manager = User::query()->where('user_id', $this->userId())
            ->first();
        if (!$manager instanceof User) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }
        $manager->avatar_user_id = 0;
        $manager->saveOrFail();
        return $this->success();
    }

    public function getAvatarUserList(int $pageIndex, int $pageSize)
    {
        $list = ManagerAvatarUser::query()->where('owner_id', $this->userId())
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->latest()
            ->get();

        //找到绑定的那个化身
        $bindAvatar = null;
        $manager = User::find($this->userId());
        if (!$manager instanceof User) {
            throw new HyperfCommonException(ErrorCode::SERVER_ERROR);
        }
        if ($manager->avatar_user_id != 0) {
            $bindAvatar = User::find($manager->avatar_user_id);
        }
        $list = $list->pluck('avatar_user');
        $list->map(function (User $user) use ($bindAvatar) {
            if (isset($bindAvatar) && $bindAvatar->user_id == $user->user_id) {
                $user->is_bind = 1;
                return $user;
            }
            $user->is_bind = 0;
            return $user;
        });

        $total = ManagerAvatarUser::query()->where('owner_id', $this->userId())->count();

        return ['total' => $total, 'list' => $list, 'current' => $bindAvatar];
    }

    public function statistic()
    {
        $today = Carbon::now()->toDateString();

        //获取用户总数
        $totalUser = User::count();
        //获取非化身总数
        $totalRealUser = Db::table('user')->selectRaw('count(`user_id`) as total from user where `user_id` not in (select `avatar_user_id` from manager_avatar_user)')
            ->get()->first->total;
        //今日新增用户
        $totalRealUserToday = User::query()->selectRaw("count(`user_id`) as total from user where `created_at` like '%$today%' and `user_id` not in (select `avatar_user_id` from manager_avatar_user)")
            ->get()->first->total;

        //评论总数
        $totalComment = Comment::count();
        $totalRealComment = Comment::query()->select([
            'comment.owner_id',
            'manager_avatar_user.avatar_user_id',
            'manager_avatar_user.owner_id'
        ])
            ->leftJoin('manager_avatar_user', 'comment.owner_id', '=', 'manager_avatar_user.avatar_user_id')
            ->whereNull('manager_avatar_user.owner_id')
            ->count();
        $totalRealCommentToday = Comment::query()->select([
            'comment.created_at',
            'comment.owner_id',
            'manager_avatar_user.avatar_user_id',
            'manager_avatar_user.owner_id'
        ])
            ->leftJoin('manager_avatar_user', 'comment.owner_id', '=', 'manager_avatar_user.avatar_user_id')
            ->whereNull('manager_avatar_user.owner_id')
            ->whereDate('comment.created_at', $today)
            ->count();

        //帖子总数
        $totalPost = Post::count();
        $totalRealPost = Post::query()->select([
            'post.owner_id',
            'manager_avatar_user.avatar_user_id',
            'manager_avatar_user.owner_id'
        ])
            ->leftJoin('manager_avatar_user', 'post.owner_id', '=', 'manager_avatar_user.avatar_user_id')
            ->whereNull('manager_avatar_user.owner_id')
            ->count();
        $totalRealPostToday = Post::query()->select([
            'post.created_at',
            'post.owner_id',
            'manager_avatar_user.avatar_user_id',
            'manager_avatar_user.owner_id'
        ])
            ->leftJoin('manager_avatar_user', 'post.owner_id', '=', 'manager_avatar_user.avatar_user_id')
            ->whereNull('manager_avatar_user.owner_id')
            ->whereDate('post.created_at', $today)
            ->count();

        //私信总数
        $totalMessage = PrivateMessage::count();
        $totalRealMessage = PrivateMessage::query()->select([
            'private_message.from_id',
            'manager_avatar_user.avatar_user_id',
            'manager_avatar_user.owner_id'
        ])
            ->leftJoin('manager_avatar_user', 'private_message.from_id', '=', 'manager_avatar_user.avatar_user_id')
            ->whereNull('manager_avatar_user.owner_id')
            ->count();
        $totalRealMessageToday = PrivateMessage::query()->select([
            'private_message.created_at',
            'private_message.from_id',
            'manager_avatar_user.avatar_user_id',
            'manager_avatar_user.owner_id'
        ])
            ->leftJoin('manager_avatar_user',
                'private_message.from_id',
                '=',
                'manager_avatar_user.avatar_user_id')
            ->whereNull('manager_avatar_user.owner_id')
            ->whereDate('private_message.created_at', $today)
            ->count();

        return [
            'user' => [
                'total' => $totalUser,
                'star' => $totalRealUser,
                'star_today' => $totalRealUserToday
            ],
            'post' => [
                'total' => $totalPost,
                'star' => $totalRealPost,
                'star_today' => $totalRealPostToday
            ],
            'comment' => [
                'total' => $totalComment,
                'star' => $totalRealComment,
                'star_today' => $totalRealCommentToday
            ],
            'message' => [
                'total' => $totalMessage,
                'star' => $totalRealMessage,
                'star_today' => $totalRealMessageToday
            ],
        ];
    }
}