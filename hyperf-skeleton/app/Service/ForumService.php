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
        return Forum::query()->with(['child_forum_list'])
            ->where('forum_id','>',1)
            ->where('type',Constants::FORUM_TYPE_MAIN)
            ->get();
    }

    public function subscribe(int $forumId)
    {
        $subscribe = UserSubscribe::query()->where('user_id', $this->userId())
            ->where('forum_id', $forumId)
            ->first();
        if ($subscribe instanceof UserSubscribe) {
            throw new HyperfCommonException(ErrorCode::RECORD_DID_EXIST);
        }
        $subscribe = new UserSubscribe();
        $subscribe->user_id = $this->userId();
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
        return UserSubscribe::query()->with(['forum'])
                                    ->where('user_id', $this->userId())
                                    ->get();
    }
}