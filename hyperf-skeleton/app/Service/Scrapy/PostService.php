<?php


namespace App\Service\Scrapy;

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

    public function addDelayPost(int $postId, int $forumId = null, int $circleId = null)
    {

    }
}