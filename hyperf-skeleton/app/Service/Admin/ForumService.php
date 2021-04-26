<?php


namespace App\Service\Admin;
use App\Constants\Constants;
use App\Model\Forum;
use App\Service\BaseService;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;

class ForumService extends BaseService
{
    public function createForum(string $name,string $icon,int $type=0, string $area=null,string $country=null,int $parentForumId=null)
    {
        $forum = Forum::query()->where('name',$name)
                                ->where('type',$type)
                                ->first();
        if ($forum instanceof Forum) {
            throw new HyperfCommonException(ErrorCode::RECORD_DID_EXIST);
        }
        $forum = new Forum();
        $forum->name = $name;
        $forum->icon = $icon;
        $forum->type = $type;
        if(isset($area)) {
            $forum->area = $area;
        }
        if (isset($country)) {
            $forum->country = $country;
        }
        if (isset($parentForumId)) {
            $forum->parent_forum_id = $parentForumId;
        }
        $forum->saveOrFail();
    }

    public function getForumList(int $pageIndex, int $pageSize)
    {
        $list = Forum::query()->with(['child_forum_list'])
                              ->where('type',Constants::FORUM_TYPE_MAIN)
                              ->offset($pageIndex * $pageSize)
                              ->limit($pageSize)
                              ->get();
        $total = Forum::query()->where('type',Constants::FORUM_TYPE_MAIN)->count();
        return ['total'=>$total,'list'=>$list];
    }
}