<?php


namespace App\Service\Admin;
use App\Model\User;
use App\Model\UserGroup;
use App\Service\BaseService;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;

class GroupService extends BaseService
{
    public function  createOrUpdate(array $params,int $groupId = null)
    {
        if(isset($groupId)) {
            $group = UserGroup::findOrFail($groupId);
        }else{
            $group = new UserGroup();
        }
        $group->name = data_get($params,'name');
        if (isset($params['labelColor'])) {
            $group->label_color = $params['labelColor'];
        }
        if (isset($params['openChoose'])) {
            $group->open_choose = $params['openChoose'];
        }
        if (isset($params['needRealName'])) {
            $group->need_real_name = $params['needRealName'];
        }
        if(!isset($groupId)) {
            $group->creator = $this->userId();
        }
        $group->saveOrFail();
        return $this->success();
    }

    public function list()
    {
        $list = UserGroup::all();
        //统计每个分组下的用户总数
        $list->map(function (UserGroup $group) {
             //统计用户数
             $total = User::query()->where('group_id',$group->group_id)->count();
             $group->total = $total;
             return $group;
        });
        return $list;
    }

    public function setUserGroup(string $mobile, int $groupId)
    {
        $user = User::query()->where('mobile',$mobile)->first();
        if(!$user instanceof User) {
            throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
        }
        $user->group_id = $groupId;
        $user->saveOrFail();
        return $this->success();
    }
}