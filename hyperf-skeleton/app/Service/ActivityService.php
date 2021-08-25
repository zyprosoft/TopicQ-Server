<?php


namespace App\Service;


use App\Constants\Constants;
use App\Model\Activity;
use App\Model\Circle;
use App\Model\Post;
use App\Model\User;
use App\Model\UserDaySign;
use Carbon\Carbon;
use Hyperf\Database\Model\Builder;
use Hyperf\Di\Annotation\Inject;

class ActivityService extends BaseService
{
    /**
     * @Inject
     * @var ForumService
     */
    protected ForumService $forumService;

    /**
     * @Inject
     * @var PostService
     */
    protected PostService $postService;

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

    public function getIndexConfigData()
    {
        $activityList = $this->getActivityList();
        $forumList = $this->forumService->getForumList();
        $postList = $this->postService->getTopNewsList();
        $today = Carbon::now()->toDateString();
        $todayPostCount = Post::query()->whereDate('created_at',$today)
            ->count();
        $circleCount = Circle::query()->where('audit_status',Constants::STATUS_OK)
            ->count();
        $memberCount = User::count();
        $postCount = Post::count();
        $today = Carbon::now()->toDateString();
        $daySignCount = UserDaySign::query()->whereDate('sign_date',$today)->count();

        $total = [
            'today' => $todayPostCount,
            'circle_count' => $circleCount,
            'member_count' => $memberCount,
            'post_count' => $postCount,
            'sign_count' => $daySignCount
        ];

        return [
            'activity_list'=>$activityList,
            'forum_list'=>$forumList,
            'post_list'=>$postList,
            'total'=>$total
        ];
    }
}