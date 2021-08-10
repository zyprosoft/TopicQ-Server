<?php


namespace App\Task;


use App\Model\Circle;
use App\Model\Post;
use Carbon\Carbon;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;

class CircleRecommendCalculateTask
{
    //圈子推荐权重计算任务
    //计算维度：1、 圈子创建时长(%5)  2、圈主积分(5%) 3、圈内容数量(15%)  4、圈子动态的点赞总数(30%)、
    //5、评论总数(30%) 6、圈成员数量(20%)
    //当前使用：1. 统计当日圈子动态发布数量，发布多的靠前

    private int $lastCircleId = 0;

    public function execute()
    {
        $pageIndex = 0;
        $pageSize = 30;

        do{
            //
            $list = Circle::query()->where(function (Builder $query){
                if($this->lastCircleId > 0) {
                    $query->where('circle_id','<', $this->lastCircleId);
                }
            })->offset($pageIndex * $pageSize)
                ->limit($pageSize)
                ->latest()
                ->get();
            if ($list->isEmpty()) {
                break;
            }
            Db::transaction(function () use ($list,&$pageIndex,$pageSize) {
                //获取当日动态数量
                $today = Carbon::now()->toDateString();
                $list->map(function (Circle $circle) use ($today) {
                    $count = Post::query()->where('circle_id',$circle->circle_id)
                        ->whereDate('created_at','like',$today)
                        ->count();
                    $circle->recommend_weight = $count;
                    $circle->save();
                });
            });
            $pageIndex++;
            $this->lastCircleId = $list->last()->circle_id;
        }while (true);
    }
}