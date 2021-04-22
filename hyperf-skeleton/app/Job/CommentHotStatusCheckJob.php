<?php


namespace App\Job;
use App\Constants\Constants;
use App\Model\Comment;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\Job;
use Hyperf\Utils\ApplicationContext;
use ZYProSoft\Facade\Cache;
use ZYProSoft\Log\Log;

class CommentHotStatusCheckJob extends Job
{
    private string $cacheKey;

    public int $postId;

    public int $starBaseCount = 6;

    public int $replyBaseCount = 5;

    public int $baseTopCount = 15;

    public function __construct(string $cacheKey, int $postId)
    {
        $this->cacheKey = $cacheKey;
        $this->postId = $postId;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        //删除队列标记位
        Cache::delete($this->cacheKey);

        Log::info("开始执行热门评论判定任务");

        //需要设置成热门评论的条件: 2.评论的点赞数前5名 3.评论最少有2个点赞
        // 4.回复数达到10条以上可单独成立 5. 点赞数达到10个以上可单独成立
        $topStarList = Comment::query()->where('post_id',$this->postId)
                                       ->where('praise_count','>=',2)
                                       ->with(['post'])
                                       ->orderByDesc('praise_count')
                                       ->limit($this->baseTopCount)
                                       ->get();
        $topReplyList = Comment::query()->where('post_id',$this->postId)
                                        ->where('reply_count','>=',2)
                                        ->with(['post'])
                                        ->orderByDesc('reply_count')
                                        ->limit($this->baseTopCount)
                                        ->get();
        $topStartKeyList = $topStarList->keyBy('comment_id');
        $topReplyKeyList = $topReplyList->keyBy('comment_id');
        if ($topStarList->isEmpty() && $topReplyList->isEmpty()) {
            return;
        }
        $hotCommentIds = collect();
        if (! $topStarList->isEmpty()) {
            //有没有超过6个点赞的
            $topStarList->map(function (Comment $comment) use (&$hotCommentIds) {
                if ($comment->praise_count >= $this->starBaseCount) {
                    $hotCommentIds->push($comment->comment_id);
                }
            });
            //如果都没有超过10个点赞的，那么取前两名点赞数量的评论作为热评
            $chooseCount = $topStarList->count() >= 2? 2:$topStarList->count();
            if ($hotCommentIds->isEmpty()) {
                $hotCommentIds->union($topStarList->slice(0,$chooseCount)->pluck('comment_id'));
            }
            $hotCommentIds = $hotCommentIds->unique();
        }
        if (! $topReplyList->isEmpty()) {
            //有没有超过5个回复的
            $topReplyList->map(function (Comment $comment) use (&$hotCommentIds) {
                if ($comment->reply_count >= $this->replyBaseCount) {
                    $hotCommentIds->push($comment->comment_id);
                }
            });
            //如果都没有超过5个回复的，那么取前两名回复数量的评论作为热评
            $chooseCount = $topReplyList->count() >= 2? 2:$topReplyList->count();
            if ($hotCommentIds->isEmpty()) {
                $hotCommentIds->union($topReplyList->slice(0,$chooseCount)->pluck('comment_id'));
            }
            $hotCommentIds = $hotCommentIds->unique();
        }
        //设置热评
        if (!$hotCommentIds->isEmpty()) {
            Comment::query()->whereIn('comment_id',$hotCommentIds->toArray())
                ->update(['is_hot'=>1]);
            $hotCommentIdsLabel = $hotCommentIds->toJson();
            Log::info("已经将($hotCommentIdsLabel)设置成热门评论");
            $hotCommentIds->map(function (int $commentId) use ($topReplyKeyList, $topStartKeyList) {
                //成为热评给用户发一条通知
                $title = "评论已成为热门评论";
                $label = "通知";
                $level = Constants::MESSAGE_LEVEL_WARN;
                if(isset($topStarList[$commentId])) {
                    //
                    $comment = $topReplyKeyList[$commentId];
                    $content = "您在帖子《{$comment->post->title}》下发表的评论《{$comment->content}》受到众人的喜爱，已经成为热门评论，请继续努力，感谢您为社区活跃做出的贡献~";
                    $notification = new AddNotificationJob($comment->owner_id,$title,$content,false,$level);
                    $notification->levelLabel = $label;
                    $notification->keyInfo = json_encode(['post_id'=>$comment->post_id]);
                    $driverFactory = ApplicationContext::getContainer()->get(DriverFactory::class);
                    $driver = $driverFactory->get('default');
                    $driver->push($notification);
                }
            });
            return;
        }
        Log::info("帖子($this->postId)暂无热门评论");
    }
}