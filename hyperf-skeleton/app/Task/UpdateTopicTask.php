<?php


namespace App\Task;


use App\Model\Post;
use App\Model\Topic;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;
use ZYProSoft\Log\Log;

class UpdateTopicTask
{
    public function execute()
    {
        //统计每一个话题的阅读次数和帖子数
        $lastTopicId = null;
        $pageIndex = 0;
        $pageSize = 30;
        $needBreak = false;
        do {
            Db::transaction(function () use (&$lastTopicId, &$pageIndex, &$needBreak, $pageSize) {
                $list = Topic::query()->where(
                    function (Builder $query) use ($lastTopicId) {
                        if (isset($lastTopicId)) {
                            $query->where('topic_id', '<', $lastTopicId);
                        }
                    }
                )->offset($pageIndex * $pageSize)
                    ->limit($pageSize)
                    ->latest()
                    ->get();
                if($list->isEmpty()) {
                    return;
                }
                $list->map(function (Topic $topic) {
                    //统计帖子数
                    $count = Post::query()->where('topic_id',$topic->topic_id)->count();
                    $readCount = Post::query()->where('topic_id',$topic->topic_id)->sum('read_count');
                    $topic->read_count = $readCount;
                    $topic->post_count = $count;
                    $topic->saveOrFail();
                });
                $lastTopicId = $list->last()->topic_id;
                if ($list->count() < $pageSize) {
                    Log::info('完成所有话题数据更新!');
                    $needBreak = true;
                    return;
                }
                $pageIndex++;
                Log::info('更新下一个话题翻页数据:'.$pageIndex);
            });
        } while ($needBreak==false);
    }
}