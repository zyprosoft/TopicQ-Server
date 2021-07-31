<?php


namespace App\Task;


class CircleExpertCalculateTask
{
    const BASE_EXPERT_POST_COUNT = 5;//成为达人最少需要的帖子数

    const BASE_EXPERT_COMMENT_COUNT = 10;//成为达人最少需要的评论数

    const BASE_EXPERT_PRAISE_COUNT = 10;//成为达人最少收到多少个点赞

    const BASE_EXPERT_FAVORITE_COUNT = 10;//成为达人最少需要被多少次收藏

    public function execute()
    {
        $lastCircleId = 0;
        //循环处理
        
    }
}