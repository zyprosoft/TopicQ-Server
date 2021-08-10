<?php


namespace App\Task;


use App\Model\CircleTopic;
use App\Model\Post;
use Carbon\Carbon;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;

class CircleTopicCalculateTask
{
    public function execute()
    {
        $pageIndex = 0;
        $pageSize = 30;

        $lastTopicId = 0;

        do{
            $list = CircleTopic::query()->where(function (Builder $query) use ($lastTopicId){
                if($lastTopicId>0) {
                    $query->where('circle_topic_id' , '<', $lastTopicId);
                }
            })->offset($pageIndex*$pageSize)
                ->limit($pageSize)
                ->latest()
                ->get();
            if($list->isEmpty()){
                return;
            }
            Db::transaction(function () use (&$list,&$pageIndex,$pageSize){
                $today = Carbon::now()->toDateString();
                $list->map(function (CircleTopic $circleTopic) use ($today){

                    $count = Post::query()->where('circle_topic_id',$circleTopic->topic_id)
                                         ->whereDate('created_at','=',$today)
                                         ->count();
                    $circleTopic->post_count = $count;
                    $circleTopic->save();
                    return $circleTopic;
                });
            });
            $pageIndex++;
            $lastTopicId = $list->last()->topic_id;
        }while(true);
    }
}