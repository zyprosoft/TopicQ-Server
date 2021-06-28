<?php


namespace App\Service;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Job\AddNotificationJob;
use App\Model\Circle;
use App\Model\User;
use App\Model\UserCircle;
use EasyWeChat\Factory;
use ZYProSoft\Exception\HyperfCommonException;

class CircleService extends BaseService
{
    public function createOrUpdate(array $params)
    {
        $name = data_get($params,'name');
        $avatar = data_get($params,'avatar');
        $background = data_get($params,'background');
        $introduce = data_get($params,'introduce');
        $qq = data_get($params,'qq');
        $categoryId = data_get($params,'categoryId');
        $password = data_get($params,'password');
        $isOpen = data_get($params,'isOpen');

        //审核文本内容
        $miniProgramConfig = config('weixin.miniProgram');
        $app = Factory::miniProgram($miniProgramConfig);
        $result = $app->content_security->checkText($name);
        $isTitleValidate = true;
        if(data_get($result,'errcode') == Constants::WX_SECURITY_CHECK_FAIL) {
            $isTitleValidate = false;
        }
        $result = $app->content_security->checkText($introduce);
        $isIntroduceValidate = true;
        if(data_get($result,'errcode') == Constants::WX_SECURITY_CHECK_FAIL) {
            $isIntroduceValidate = false;
        }
        if($isTitleValidate == false || $isIntroduceValidate == false) {
            //发送一条审核不通过通知
            $levelLabel = '警告';
            $level = Constants::MESSAGE_LEVEL_BLOCK;
            $title = '圈子审核不通过';
            if ($isTitleValidate == false) {
                $content = "您的圈子名字《{$name}》内容包含敏感信息，已被管理员审核拒绝";
            }else{
                $content = "您的圈子介绍《{$introduce}》内容包含敏感信息，已被管理员审核拒绝";
            }
            $userId = $this->userId();
            $notification = new AddNotificationJob($userId,$title,$content,false,$level);
            $notification->levelLabel = $levelLabel;
            $this->push($notification);
        }

        $circleId = data_get($params,'circleId');
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
            if (isset($password)) {
                $circle->password = password_hash($password,PASSWORD_DEFAULT);
                $circle->is_open = 0;
                $circle->use_password = 1;
            }
            if (isset($isOpen)) {
                $circle->is_open = $isOpen;
            }
        }else{
            $circle = new Circle();
            $circle->name = $name;
            $circle->avatar = $avatar;
            $circle->background = $background;
            $circle->introduce = $introduce;
            $circle->qq = $qq;
            $circle->category_id = $categoryId;
            $circle->is_open = $isOpen;
            $circle->owner_id = $this->userId();
            if (isset($password)) {
                $circle->password = password_hash($password,PASSWORD_DEFAULT);
                $circle->is_open = 0;
                $circle->use_password = 1;
            }
        }
        $circle->saveOrFail();
        //发送建圈成功通知
        if(!isset($circleId)) {
            //发送一条审核不通过通知
            $levelLabel = '通知';
            $level = Constants::MESSAGE_LEVEL_BLOCK;
            $title = '圈子审核通过';
            $content = "您的圈子《{$name}》已经创建成功并审批通过!";
            $userId = $this->userId();
            $notification = new AddNotificationJob($userId,$title,$content,false,$level);
            $notification->levelLabel = $levelLabel;
            $keyInfo = ['circle_id'=>$circle->circle_id];
            $notification->keyInfo = json_encode($keyInfo);
            $this->push($notification);
        }
        return $this->success();
    }

    public function joinCircle(int $circleId, string $password = null, string $note = null)
    {
        $circle = Circle::findOrFail($circleId);
        //用户是不是已经加入
        $userCircle = UserCircle::query()->where('user_id',$this->userId())
            ->where('circle_id',$circleId)
            ->first();
        if ($userCircle instanceof UserCircle) {
            throw new HyperfCommonException(ErrorCode::DO_NOT_REPEAT_ACTION);
        }
        if ($circle->is_open == Constants::STATUS_OK) {
            $userCircle = new UserCircle();
            $userCircle->user_id = $this->userId();
            $userCircle->circle_id = $circleId;
            $userCircle->saveOrFail();
            return $this->success();
        }
        //使用密码进入
        if ($circle->use_password == Constants::STATUS_OK) {
            if (!isset($password)) {
                throw new HyperfCommonException(ErrorCode::CIRCLE_JOIN_NEED_PASSWORD);
            }
            //校验密码
            $isVerify = password_verify($password,$circle->password);
            if (!$isVerify) {
                throw new HyperfCommonException(ErrorCode::CIRCLE_JOIN_PASSWORD_INVALIDATE);
            }
            $userCircle = new UserCircle();
            $userCircle->user_id = $this->userId();
            $userCircle->circle_id = $circleId;
            $userCircle->saveOrFail();
        }
        //需要审核
        if (!isset($note)) {

        }
    }
}