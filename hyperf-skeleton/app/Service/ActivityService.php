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

    /**
     * @Inject
     * @var ShopService
     */
    protected ShopService $shopService;

    /**
     * @Inject
     * @var OfficialAccountService
     */
    protected OfficialAccountService $officialAccountService;

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
        $total = $this->innerGetIndexTotalInfo();
        $shop = $this->shopService->info(Constants::DEFAULT_SHOP_ID);
        $hasShop = $shop->status == Constants::STATUS_OK ? 1:0;

        return [
            'activity_list'=>$activityList,
            'forum_list'=>$forumList,
            'post_list'=>$postList,
            'total'=>$total,
            'has_shop'=>$hasShop
        ];
    }

    public function innerGetIndexTotalInfo()
    {
        $today = Carbon::now()->toDateString();
        $todayPostCount = Post::query()->whereDate('created_at',$today)
            ->count();
        $circleCount = Circle::query()->where('audit_status',Constants::STATUS_OK)
            ->count();
        $memberCount = User::count();
        $postCount = Post::count();
        $today = Carbon::now()->toDateString();
        $daySignCount = UserDaySign::query()->whereDate('sign_date',$today)->count();

        //检查用户是否关注了公众号
        $isSubscribe = $this->officialAccountService->getUserAttentionOfficialAccountStatus();

        return [
            'today' => $todayPostCount,
            'circle_count' => $circleCount,
            'member_count' => $memberCount,
            'post_count' => $postCount,
            'sign_count' => $daySignCount,
            'fa_subscribe' => $isSubscribe
        ];
    }

    public function getIndexTotalInfo()
    {
        $total = $this->innerGetIndexTotalInfo();
        $topNews = $this->postService->getTopNewsList();
        return ['total'=>$total,'post_list'=>$topNews];
    }
}