<?php


namespace App\Service\Admin;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Model\Advice;
use App\Model\Comment;
use App\Model\ManagerAvatarUser;
use App\Model\Post;
use App\Model\PrivateMessage;
use App\Model\ReportComment;
use App\Model\ReportPost;
use App\Model\Role;
use App\Model\Topic;
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

    public function updateUserStatus(int $userId, int $status, string $note = null)
    {
        $user = User::findOrFail($userId);
        $user->status = $status;
        if(isset($note)) {
            $user->block_reason = $note;
        }
        $user->saveOrFail();
        return $this->success($user);
    }

    public function searchUser(int $pageIndex, int $pageSize, int $lastUserId = null, string $nickname = null, string $mobile = null)
    {
        $column = null;
        $value = null;

        if(isset($nickname)) {
            $column = 'nickname';
            $value = "%$nickname%";
        }

        if (isset($mobile)) {
            $column = 'mobile';
            $value = "%$mobile%";
        }

        $list = User::query()->select([
                                'user_id',
                                'avatar',
                                'nickname',
                                'mobile',
                                'role_id',
                                'user.created_at',
                                'area',
                                'country',
                                'status'
                             ])
                            ->leftJoin('manager_avatar_user','user.user_id','=','manager_avatar_user.avatar_user_id')
                            ->where(function (Builder $query) use ($column, $value) {
                                if (isset($column) && isset($value)) {
                                    $query->where($column,'like',$value);
                                }
                             })
                             ->where(function (Builder $query) use ($lastUserId){
                                 if(isset($lastUserId)) {
                                     $query->where('user_id','<',$lastUserId);
                                 }
                             })
                             ->whereNotNull('mobile')
                             ->whereNull('manager_avatar_user.avatar_user_id')
                             ->offset($pageIndex * $pageSize)
                             ->limit($pageSize)
                             ->orderByDesc('user_id')
                             ->get()
                             ->makeVisible('mobile');
        //加密手机号码
        $list->map(function (User $user) {
            if (!empty($user->mobile)) {
                $user->mobile = substr_replace($user->mobile, '****', 0, 7);
            }
            return $user;
        });

        $total = User::query()->where('nickname','like', "%$nickname%")->count();
        return  ['total'=>$total,'list'=>$list];
    }

    public function getUserList(int $pageIndex, int $pageSize, int $lastId = null)
    {
        $list = User::query()->where(function (Builder $query) use ($lastId) {
            if (isset($lastId)) {
                $query->where('user_id', '<', $lastId);
            }
        })->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->latest()
            ->get()
            ->makeVisible('mobile');

        $total = User::count();

        return ['total' => $total, 'list' => $list];
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
        $user->group_id = data_get($params,'groupId');
        $joinTime = data_get($params, 'joinTime');
        $user->sex = data_get($params,'sex');
        $user->hobby_label = json_encode(data_get($params,'hobbyLabels'));
        $user->sign_status = data_get($params,'signStatus');
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
            $user->group_id = data_get($params,'groupId');
            $user->token = Str::random(64);
            $user->wx_token = Str::random(64);
            $user->wx_openid = Str::random(64);
            $user->sex = data_get($params,'sex');
            $user->hobby_label = json_encode(data_get($params,'hobbyLabels'));
            $user->sign_status = data_get($params,'signStatus');
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
        $totalRealUser = User::query()->select([
            'user.user_id',
            'manager_avatar_user.avatar_user_id',
            'manager_avatar_user.owner_id'
        ])
            ->leftJoin('manager_avatar_user', 'user.user_id', '=', 'manager_avatar_user.avatar_user_id')
            ->whereNull('manager_avatar_user.owner_id')
            ->count();
        $totalRealUserToday = User::query()->select([
            'user.created_at',
            'user.user_id',
            'manager_avatar_user.avatar_user_id',
            'manager_avatar_user.owner_id'
        ])
            ->leftJoin('manager_avatar_user', 'user.user_id', '=', 'manager_avatar_user.avatar_user_id')
            ->whereNull('manager_avatar_user.owner_id')
            ->whereDate('user.created_at', $today)
            ->count();

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

    public function getUserRoleList()
    {
        return Role::all();
    }

    public function setUserRole(int $userId, int $roleId)
    {
        $user = User::findOrFail($userId);
        $user->role_id = $roleId;
        $user->saveOrFail();
    }

    public function getUnreadCountInfo()
    {
        //统计未审核的帖子数量
        $waitAuditCount = Post::query()->where('audit_status',Constants::STATUS_WAIT)
            ->count();
        //统计举报未处理的帖子数量
        $reportPostCount = ReportPost::query()->where('audit_status',Constants::STATUS_WAIT)
            ->count();
        //统计评论举报的数量
        $reportCommentCount = ReportComment::query()->where('audit_status',Constants::STATUS_WAIT)
            ->count();
        //统计未审核话题的数量
        $waitAuditTopicCount = Topic::query()->where('audit_status',Constants::STATUS_WAIT)
            ->count();
        $total = $waitAuditCount + $reportPostCount + $reportCommentCount + $waitAuditTopicCount;
        $postTotal = $waitAuditCount + $reportPostCount + $reportCommentCount;

        return [
            'total' => $total,
            'post_audit_count' => $waitAuditCount,
            'post_report_count' => $reportPostCount,
            'comment_report_count' => $reportCommentCount,
            'topic_audit_count' => $waitAuditTopicCount,
            'post_total' => $postTotal
        ];
    }
}