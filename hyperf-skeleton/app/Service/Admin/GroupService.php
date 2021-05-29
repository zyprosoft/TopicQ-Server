<?php


namespace App\Service\Admin;
use App\Model\User;
use App\Model\UserGroup;
use App\Service\BaseService;

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
}