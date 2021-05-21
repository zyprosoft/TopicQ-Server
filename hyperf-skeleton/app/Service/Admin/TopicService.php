<?php


namespace App\Service\Admin;
use App\Model\Topic;
use App\Service\BaseService;

class TopicService extends BaseService
{
    public function getTopicList(int $pageIndex, int $pageSize)
    {
        $list = Topic::query()->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->orderByDesc('sort_index')
            ->orderByDesc('recommend_weight')
            ->latest()
            ->get();
        $total = Topic::count();
        return ['total'=>$total,'list'=>$list];
    }

    public function getMaxRecommendWeight()
    {
        return Topic::query()->max('recommend_weight');
    }

    public function updateRecommendWeight(int $topicId, int $weight)
    {
        $topic = Topic::findOrFail($topicId);
        $topic->recommend_weight = $weight;
        $topic->saveOrFail();
    }
}