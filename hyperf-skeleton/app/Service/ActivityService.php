<?php


namespace App\Service;


use App\Constants\Constants;
use App\Model\Activity;
use Hyperf\Database\Model\Builder;

class ActivityService extends BaseService
{
    public function getActivityList(int $type = null, int $forumId = null)
    {
        if (!isset($type)) {
            $type = Constants::ACTIVITY_TYPE_INDEX;
        }
        return Activity::query()->where('status',Constants::STATUS_WAIT)
            ->where('show_type',$type)
            ->when(isset($forumId),function (Builder $query) use ($forumId) {
                $query->where('forum_id',$forumId);
            })
            ->orderByDesc('sort_index')->get();
    }
}