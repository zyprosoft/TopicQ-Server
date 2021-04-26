<?php


namespace App\Service;


use App\Constants\Constants;
use App\Model\Forum;
use App\Model\UserSubscribe;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;

class ForumService extends BaseService
{
    public function getForumList()
    {
        $list = Forum::query()->with(['child_forum_list'])
            ->where('forum_id','>',1)
            ->where('type',Constants::FORUM_TYPE_MAIN)
            ->get();

        //增加订阅状态
        $mySubscribeList = UserSubscribe::query()->where('user_id',$this->userId())
                                                 ->get()
                                                 ->keyBy('forum_id');

        $list->map(function (Forum $forum) use ($mySubscribeList) {
            if($mySubscribeList->get($forum->forum_id) !== null) {
                $forum->is_subscribe = 1;
            }else{
                $forum->is_subscribe = 0;
            }
            return $forum;
        });

        return $list;
    }

    public function subscribe(int $forumId, int $userId = null)
    {
        if(!isset($userId)) {
            $userId = $this->userId();
        }
        $subscribe = UserSubscribe::query()->where('user_id', $userId)
            ->where('forum_id', $forumId)
            ->first();
        if ($subscribe instanceof UserSubscribe) {
            throw new HyperfCommonException(ErrorCode::RECORD_DID_EXIST);
        }
        $subscribe = new UserSubscribe();
        $subscribe->user_id = $userId;
        $subscribe->forum_id = $forumId;
        $subscribe->saveOrFail();
        return $this->success();
    }

    public function unsubscribe(int $forumId)
    {
        $subscribe = UserSubscribe::query()->where('user_id', $this->userId())
            ->where('forum_id', $forumId)
            ->first();
        if (!$subscribe instanceof UserSubscribe) {
            throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
        }
        $subscribe->delete();
        return $this->success();
    }

    public function mySubscribeList()
    {
        $list = UserSubscribe::query()->with(['forum'])
                                    ->where('user_id', $this->userId())
                                    ->get()
                                    ->pluck('forum');
        $list->map(function (Forum $forum) {
            $forum->is_subscribe = 1;
            return $forum;
        });
        return $list;
    }
}