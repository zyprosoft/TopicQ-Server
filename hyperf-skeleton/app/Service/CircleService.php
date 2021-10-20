<?php


namespace App\Service;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Job\AddNotificationJob;
use App\Model\Circle;
use App\Model\CircleCategory;
use App\Model\CircleTopic;
use App\Model\JoinCircleApply;
use App\Model\User;
use App\Model\UserCircle;
use Carbon\Carbon;
use EasyWeChat\Factory;
use Hyperf\DbConnection\Db;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Facade\Auth;
use ZYProSoft\Log\Log;

class CircleService extends BaseService
{
    protected function isAdminUsingAvatar()
    {
        //当前用户是不是管理员
        if (Auth::isGuest()) {
            return Constants::STATUS_NOT;
        }
        $userId = Auth::userId();
        $user = User::find($userId);
        if ($user->role_id <= Constants::USER_ROLE_SUB_ADMIN) {
            //检查是不是在使用化身
            if ($user->avatar_user_id > 0) {
                Log::info("使用化身($user->avatar_user_id)");
                return Constants::STATUS_OK;
            }
        }
        return Constants::STATUS_NOT;
    }

    //重载获取当前用户ID的方法
    protected function userId()
    {
        //当前用户是不是管理员
        if (Auth::isGuest()) {
            return Auth::userId();
        }
        $userId = Auth::userId();
        $user = User::find($userId);
        if ($user->role_id <= Constants::USER_ROLE_SUB_ADMIN) {
            //检查是不是在使用化身
            if ($user->avatar_user_id > 0) {
                Log::info("使用化身($user->avatar_user_id)");
                return $user->avatar_user_id;
            }
        }
        return $userId;
    }

    public function createOrUpdate(array $params)
    {
        $name = data_get($params, 'name');
        $introduce = data_get($params, 'introduce');

        //如果是创建圈子
        $user = User::findOrFail($this->userId());
        if(!isset($params['circleId'])) {
            //检查积分是否足够
            if ($user->score < Constants::CREATE_CIRCLE_COST_SCORE) {
                throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::PARAM_ERROR,'您的积分不足，无法创建圈子!');
            }
        }

        //审核文本内容
        $miniProgramConfig = config('weixin.miniProgram');
        $app = Factory::miniProgram($miniProgramConfig);
        $result = $app->content_security->checkText($name);
        $isTitleValidate = true;
        if (data_get($result, 'errcode') == Constants::WX_SECURITY_CHECK_FAIL) {
            $isTitleValidate = false;
        }
        $result = $app->content_security->checkText($introduce);
        $isIntroduceValidate = true;
        if (data_get($result, 'errcode') == Constants::WX_SECURITY_CHECK_FAIL) {
            $isIntroduceValidate = false;
        }
        if ($isTitleValidate == false || $isIntroduceValidate == false) {
            //发送一条审核不通过通知
            $levelLabel = '警告';
            $level = Constants::MESSAGE_LEVEL_BLOCK;
            $title = '圈子审核不通过';
            if ($isTitleValidate == false) {
                $content = "您的圈子名字《{$name}》内容包含敏感信息，已被管理员审核拒绝";
            } else {
                $content = "您的圈子介绍《{$introduce}》内容包含敏感信息，已被管理员审核拒绝";
            }
            $userId = $this->userId();
            $notification = new AddNotificationJob($userId, $title, $content, false, $level);
            $notification->levelLabel = $levelLabel;
            $this->push($notification);
        }

        Db::transaction(function() use ($params,$user,$name,$introduce){

            $qq = data_get($params, 'qq');
            $categoryId = data_get($params, 'categoryId');
            $password = data_get($params, 'password');
            $isOpen = data_get($params, 'isOpen');
            $openScore = data_get($params, 'openScore');
            $tags = data_get($params, 'tags');
            $avatar = data_get($params, 'avatar');
            $background = data_get($params, 'background');

            $circleId = data_get($params, 'circleId');
            if (isset($circleId)) {
                $circle = Circle::findOrFail($circleId);
                if (isset($name)) {
                    $circle->name = $name;
                }
                if (isset($avatar)) {
                    $circle->avatar = $avatar;
                }
                if (isset($background)) {
                    $circle->background = $background;
                }
                if (isset($introduce)) {
                    $circle->introduce = $introduce;
                }
                if (isset($qq)) {
                    $circle->qq = $qq;
                }
                if (isset($categoryId)) {
                    $circle->category_id = $categoryId;
                }
                if (isset($tags)) {
                    $circle->tags = json_encode($tags);
                }
                if (isset($password)) {
                    $circle->password = password_hash($password, PASSWORD_DEFAULT);
                    $circle->is_open = Constants::STATUS_NOT;
                    $circle->use_password = Constants::STATUS_OK;
                }
                if (isset($openScore)) {
                    $circle->open_score = $openScore;
                    $circle->is_open = Constants::STATUS_NOT;
                }
                if (isset($isOpen)) {
                    $circle->is_open = $isOpen;
                }
            } else {
                $circle = new Circle();
                $circle->name = $name;
                $circle->avatar = $avatar;
                $circle->background = $background;
                $circle->introduce = $introduce;
                $circle->qq = $qq;
                $circle->category_id = $categoryId;
                $circle->is_open = $isOpen;
                $circle->owner_id = $this->userId();
                if (isset($tags)) {
                    $circle->tags = json_encode($tags);
                }
                if (isset($password)) {
                    $circle->password = password_hash($password, PASSWORD_DEFAULT);
                    $circle->is_open = 0;
                    $circle->use_password = 1;
                }
                if (isset($openScore)) {
                    $circle->open_score = $openScore;
                    $circle->is_open = Constants::STATUS_NOT;
                }
            }
            //目前先自动审核通过
            $circle->audit_status = Constants::STATUS_OK;
            $circle->saveOrFail();
            //发送建圈成功通知
            if (!isset($circleId)) {
                //发送一条审核通过通知
                $levelLabel = '通知';
                $level = Constants::MESSAGE_LEVEL_WARN;
                $title = '圈子审核通过';
                $content = "您的圈子《{$name}》已经创建成功并审批通过!";
                $userId = $this->userId();
                $notification = new AddNotificationJob($userId, $title, $content, false, $level);
                $notification->levelLabel = $levelLabel;
                $keyInfo = ['circle_id' => $circle->circle_id];
                $notification->keyInfo = json_encode($keyInfo);
                $this->push($notification);
            }
            //消耗积分
            if(!isset($params['circleId'])) {
                $user->score -= Constants::CREATE_CIRCLE_COST_SCORE;
                $user->saveOrFail();
            }
        });

        return $this->success();
    }

    public function joinCircle(int $circleId, string $password = null, string $note = null)
    {
        $circle = Circle::findOrFail($circleId);
        //用户是不是已经加入
        $userCircle = UserCircle::query()->where('user_id', $this->userId())
            ->where('circle_id', $circleId)
            ->first();
        if ($userCircle instanceof UserCircle) {
            return $this->success();
        }
        //公开
        if ($circle->is_open == Constants::STATUS_OK) {
            $userCircle = new UserCircle();
            $userCircle->user_id = $this->userId();
            $userCircle->circle_id = $circleId;
            $userCircle->saveOrFail();
            //刷新圈子数据
            $this->queueService->refreshCircleCountInfo($circleId);
            return $this->success();
        }
        //使用密码进入
        if ($circle->use_password == Constants::STATUS_OK) {
            if (!isset($password)) {
                throw new HyperfCommonException(ErrorCode::CIRCLE_JOIN_NEED_PASSWORD);
            }
            Log::info("input password:$password");
            //校验密码
            $isVerify = password_verify($password, $circle->password);
            if (!$isVerify) {
                throw new HyperfCommonException(ErrorCode::CIRCLE_JOIN_PASSWORD_INVALIDATE);
            }
            $userCircle = new UserCircle();
            $userCircle->user_id = $this->userId();
            $userCircle->circle_id = $circleId;
            $userCircle->saveOrFail();
            //刷新圈子数据
            $this->queueService->refreshCircleCountInfo($circleId);
            return $this->success();
        }
        //使用积分进入
        if ($circle->open_score > 0) {
            Db::transaction(function () use ($circle) {
                $user = User::query()->where('user_id', $this->userId())->lockForUpdate()->first();
                if (!$user instanceof User) {
                    throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
                }
                if ($user->score < $circle->open_score) {
                    throw new HyperfCommonException(ErrorCode::CIRCLE_JOIN_NOT_ENOUGH_SCORE);
                }
                $user->score -= $circle->open_score;
                $user->saveOrFail();
                //圈主获得积分
                $circleOwner = User::findOrFail($circle->owner_id);
                $circleOwner->increment('score', $circle->open_score);
                //加入圈子
                $userCircle = new UserCircle();
                $userCircle->user_id = $this->userId();
                $userCircle->circle_id = $circle->circle_id;
                $userCircle->saveOrFail();
                //刷新圈子数据
                $this->queueService->refreshCircleCountInfo($circle->circle_id);
            });
            return $this->success();
        }

        //需要审核
        if (!isset($note)) {
            throw new HyperfCommonException(ErrorCode::CIRCLE_JOIN_NEED_REASON);
        }
        //创建申请
        $joinApply = new JoinCircleApply();
        $joinApply->user_id = $this->userId();
        $joinApply->note = $note;
        $joinApply->circle_id = $circle->circle_id;
        $joinApply->circle_owner_id = $circle->owner_id;
        $joinApply->saveOrFail();
        return $this->success();
    }

    public function cancelCircle(int $circleId)
    {
        $userCircle = UserCircle::query()->where('user_id', $this->userId())
            ->where('circle_id', $circleId)
            ->first();
        if (!$userCircle instanceof UserCircle) {
            return $this->success();
        }
        $userCircle->delete();
        //刷新圈子数据
        $this->queueService->refreshCircleCountInfo($circleId);
        return $this->success();
    }

    public function getJoinApplyList(int $pageIndex, int $pageSize)
    {
        $applyList = JoinCircleApply::query()->where('circle_owner_id', $this->userId())
            ->where('audit_status', Constants::STATUS_WAIT)
            ->latest()
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();
        $total = JoinCircleApply::query()->where('circle_owner_id', $this->userId())
            ->where('audit_status', Constants::STATUS_WAIT)
            ->count();
        return ['list' => $applyList, 'total' => $total];
    }

    public function auditJoinApply(int $applyId, int $status)
    {
        Db::transaction(function () use ($applyId, $status) {
            $apply = JoinCircleApply::findOrFail($applyId);
            //是不是圈主
            if ($apply->circle_owner_id !== $this->userId()) {
                throw new HyperfCommonException(ErrorCode::CIRCLE_NOT_OWN);
            }
            $apply->audit_status = $status;
            //通过
            if ($status == Constants::STATUS_OK) {
                $userCircle = new UserCircle();
                $userCircle->user_id = $apply->user_id;
                $userCircle->circle_id = $apply->circle_id;
                $userCircle->saveOrFail();
                //刷新圈子数据
                $this->queueService->refreshCircleCountInfo($apply->circle_id);
            }
            //审核不通过或者失败发送消息
            if ($status == Constants::STATUS_OK) {
                $title = "加入圈子成功!";
                $content = "《{$apply->circle->name}》圈主已经同意您的申请!快去进入圈子与更多圈友互动吧";
            } else {
                $title = "加入圈子被拒绝!";
                $content = "很遗憾，《{$apply->circle->name}》圈主不同意你的入圈申请!";
            }
            $levelLabel = '通知';
            $level = Constants::MESSAGE_LEVEL_WARN;
            $notification = new AddNotificationJob($apply->user_id, $title, $content, false, $level);
            $notification->levelLabel = $levelLabel;
            if ($status == Constants::STATUS_OK) {
                $keyInfo = ['circle_id' => $apply->circle_id];
                $notification->keyInfo = json_encode($keyInfo);
            }
            $this->push($notification);
        });
        return $this->success();
    }

    public function getCircleByCategory(int $categoryId, int $pageIndex, int $pageSize)
    {
        $list = Circle::query()->where('category_id', $categoryId)
            ->where('audit_status', Constants::STATUS_OK)
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();
        $total = Circle::query()->where('category_id', $categoryId)
            ->where('audit_status', Constants::STATUS_OK)
            ->count();
        return ['list' => $list, 'total' => $total];
    }

    public function getCircleCategoryList()
    {
        return CircleCategory::all();
    }

    public function getCircleInfoById(int $circleId)
    {
        $circle = Circle::findOrFail($circleId);
        if (Auth::isGuest() == false) {
            //是否已经加入
            $userCircle = UserCircle::query()->where('user_id', $this->userId())
                ->where('circle_id', $circleId)
                ->first();
            if (!$userCircle instanceof UserCircle) {
                $circle->is_joined = 0;
            } else {
                $circle->is_joined = 1;
            }
        } else {
            $circle->is_joined = 0;
        }
        //管理员使用化身状态
        $circle->using_avatar = $this->isAdminUsingAvatar();
        return $circle;
    }

    public function getTopicListByCircleId(int $circleId, int $pageIndex, int $pageSize)
    {
        $list = CircleTopic::query()->where('circle_id', $circleId)
            ->latest()
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();
        $total = CircleTopic::query()->where('circle_id', $circleId)->count();
        return ['list' => $list, 'total' => $total];
    }

    public function updateUserCircleActiveTime(int $userId, int $circleId)
    {
        $userCircle = UserCircle::query()->where('user_id', $userId)
            ->where('circle_id', $circleId)
            ->first();
        if (!$userCircle instanceof UserCircle) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }
        $userCircle->last_active_time = Carbon::now()->toDateTimeString();
        $userCircle->saveOrFail();
    }

    public function getCircleMemberList(int $circleId, int $pageIndex, int $pageSize)
    {
        //圈主
        $circle = Circle::findOrFail($circleId);

        $list = UserCircle::query()->where('circle_id', $circleId)
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->orderByDesc('last_active_time')
            ->get()
            ->pluck('author');

        $list = collect([$circle->author])->merge($list)->unique();

        $total = UserCircle::query()->where('circle_id', $circleId)->count();
        return ['list' => $list, 'total' => $total];
    }

    public function getCircleIndexRecommendList()
    {
        //获取
        $circle = Circle::query()->limit(3)
            ->orderByDesc('recommend_weight')
            ->get();
        $circleUser = UserCircle::query()->selectRaw('distinct user_id,last_active_time')
            ->limit(30)
            ->orderByDesc('last_active_time')
            ->get()
            ->pluck('author');
        $topic = CircleTopic::query()
            ->limit(4)
            ->orderByDesc('today_post_count')
            ->get();
        return ['circle_list' => $circle, 'user_list' => $circleUser, 'topic_list' => $topic];
    }

    public function getIndexRecommendTopicList()
    {
        //随机获取
        $total = CircleTopic::count();
        $offset = rand(0, floor($total - 5));
        return CircleTopic::query()
            ->offset($offset)
            ->limit(4)
            ->orderByDesc('today_post_count')
            ->orderByDesc('post_count')
            ->orderByDesc('member_count')
            ->get();
    }

    public function getCircleByUserId(int $pageIndex, int $pageSize, int $userId = null)
    {
        if (!isset($userId)) {
            $userId = $this->userId();
        }

        $joinedList = UserCircle::query()->where('user_id', $userId)
            ->with(['circle'])
            ->latest()
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get()
            ->pluck('circle');
        $joinedCount = UserCircle::query()->where('user_id', $userId)->count();

        $list = Circle::query()->where('owner_id', $userId)
            ->where('audit_status', Constants::STATUS_OK)
            ->latest()
            ->get();
        $total = Circle::query()->where('owner_id', $userId)
            ->where('audit_status', Constants::STATUS_OK)
            ->count();

        $list = $list->merge($joinedList)->unique();
        $total += $joinedCount;
        return ['list' => $list, 'total' => $total];
    }

    public static function randomRecommendList(int $count = 6)
    {
        //随机推荐圈子,按照成员数，动态数，话题数排序，必须要有2个以上成员，2个以上动态才能被随机推荐
        //一次推荐指定数量
        $maxOffset = Circle::count() - $count;
        $offset = rand(0, $maxOffset);
        return Circle::query()
            ->offset($offset)
            ->limit($count)
            ->orderByDesc('post_count')
            ->orderByDesc('member_count')
            ->orderByDesc('topic_count')
            ->get();
    }

    public function getAllCircleBySort(int $pageIndex, int $pageSize)
    {
        $list = Circle::query()->where('audit_status',Constants::STATUS_OK)
                               ->offset($pageIndex * $pageSize)
                               ->limit($pageSize)
                               ->orderByDesc('member_count')
                               ->orderByDesc('post_count')
                               ->orderByDesc('topic_count')
                               ->get();
        $total = Circle::count();

        return ['list'=>$list,'total'=>$total];
    }

    public function getAllCircleList()
    {
        return Circle::all();
    }
}