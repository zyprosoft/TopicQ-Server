<?php


namespace App\Service\Admin;
use App\Constants\Constants;
use App\Model\Forum;
use App\Model\UserSubscribe;
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

    public function editForum(int $forumId, string $name = null,string $icon = null, int $type=null, string $area=null,string $country=null,int $parentForumId=null)
    {
        $forum = Forum::query()->where('forum_id',$forumId)
            ->first();
        if (!$forum instanceof Forum) {
            throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
        }
        if(isset($name)) {
            $forum->name = $name;
        }
        if (isset($icon)) {
            $forum->icon = $icon;
        }
        if (isset($type)) {
            $forum->type = $type;
        }
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
}