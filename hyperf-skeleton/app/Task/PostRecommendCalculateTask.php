<?php


namespace App\Task;

use App\Model\Post;
use Carbon\Carbon;
use Hyperf\DbConnection\Db;
use ZYProSoft\Log\Log;

/**
 * 定时计算帖子的推荐权重，以便更新帖子的推荐顺序
 * Class PostRecommendCalculateTask
 * @package App\Task
 */
class PostRecommendCalculateTask
{
    public function execute()
    {
        //统计收藏、评论、点赞数、发表时间、阅读数
        $baseWeight = 1000;

        $pageIndex = 0;
        $pageSize = 30;
        $lastPostId = 0;

        //总数
        $gravity = 1.5;

        do{
            $postList = Post::query()->select([
                'favorite_count','comment_count','read_count','join_user_count','post_id','recommend_weight'
            ])
                ->where('post_id','>', $lastPostId)
                ->offset($pageIndex)
                ->limit($pageSize)
                ->get();
            $lastPostId = data_get($postList->last(),'post_id');
            Db::transaction(function () use (&$postList,$baseWeight,$gravity){
                $postList->map(function (Post $post) use ($baseWeight,$gravity) {
                    //热度计算
                    $createdAt = new Carbon($post->created_at);
                    $createdAtTs = round($createdAt->diffInHours(Carbon::now()))+1;
                    $createdAtTs = $createdAtTs > 24? 24:$createdAtTs;//超过一天，系数一样
                    $postTotal = $post->read_count;//阅读系数放大
                    $postTotal = $postTotal + $post->favorite_count * 100 * 2; //收藏系数放大
                    $postTotal = $postTotal + $post->comment_count * 100 * 4; //评论系数放大
                    $postTotal = $postTotal + $post->join_user_count * 100 * 3;//参加人数放大
                    $hotWeight = ($postTotal+$baseWeight)/pow($createdAtTs,$gravity);
                    $post->recommend_weight = round($hotWeight);
                    $post->save();
                });
            });
            if ($postList->count() < $pageSize) {
                break;
            }
        }while(true);

        Log::info("完成帖子推荐度统计");
    }
}