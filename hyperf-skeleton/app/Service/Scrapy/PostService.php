<?php


namespace App\Service\Scrapy;

use App\Model\DelayPostTask;
use App\Model\Scrapy\Comment;
use App\Model\Scrapy\Post;
use App\Model\Scrapy\Thread;
use App\Service\BaseService;
use Hyperf\Database\Model\Builder;

class PostService extends BaseService
{
    public function getPostList(int $pageIndex, int $pageSize,string $keyword = null)
    {
        $list = Thread::query()
                            ->where(function (Builder $query) use ($keyword) {
                                if (isset($keyword)) {
                                    $query->where('title','like',"%$keyword%");
                                }
                            })
                            ->offset($pageIndex * $pageSize)
                             ->limit($pageSize)
                             ->orderByDesc('id')
                             ->get();
        $total = Thread::count();
        return ['list'=>$list,'total'=>$total];
    }

    public function getCommentList(int $postId, int $pageIndex, int $pageSize)
    {
        $list = Post::query()->where('thread_id', $postId)
                               ->offset($pageIndex * $pageSize)
                               ->limit($pageSize)
                               ->get();
        $total = Post::query()->where('thread_id', $postId)->count();
        return ['list'=>$list,'total'=>$total];
    }

    public function addDelayPost(string $postId, $needComment = 0, int $forumId = null, int $circleId = null)
    {
        $task = new DelayPostTask();
        $task->post_id = $postId;
        $task->forum_id = $forumId;
        $task->circle_id = $circleId;
        $task->need_comment = $needComment;
        $task->is_active = $circleId>0? 1:0;
        $task->saveOrFail();
        return $this->success();
    }
}