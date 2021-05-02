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
        $baseWeight = 10;

        $pageIndex = 0;
        $pageSize = 30;
        $lastPostId = 0;

        //总数
        $gravity = 1.5;

        do{
            $postList = Post::query()->select([
                'favorite_count','comment_count','read_count','post_id','recommend_weight'
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
                    $hotWeight = ($post->total + $baseWeight )/pow($createdAt->timestamp+1,$gravity);
                    $post->recommend_weight = $hotWeight;
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