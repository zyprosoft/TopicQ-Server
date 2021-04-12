<?php


namespace App\Service;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Job\PostUpdateJob;
use App\Model\Comment;
use App\Model\Post;
use App\Model\ReportComment;
use Hyperf\Database\Model\Builder;
use ZYProSoft\Exception\HyperfCommonException;
use App\Job\UniqueJobQueue;

use Hyperf\Di\Annotation\Inject;
class CommentService extends BaseService
{
    /**
     * @Inject
     * @var UniqueJobQueue
     */
    private UniqueJobQueue $queueService;

    public function create(int $postId, string $content, array $imageList = null, string $link = null)
    {
        $post = Post::findOrFail($postId);

        $comment = new Comment();
        $comment->content = $content;
        $comment->owner_id = $this->userId();
        $comment->post_id = $postId;
        
        if (isset($link)) {
            $comment->link = $link;
        }
        if (isset($imageList)) {
            $comment->image_list = implode(';', $imageList);
        }
        $comment->saveOrFail();

        //更新帖子统计信息
        $this->queueService->updatePost($postId);

        $this->queueService->updateUser($post->owner_id);

        return $comment;
    }

    public function checkOwn(int $commentId)
    {
        $comment = Comment::query()->where('owner_id', $this->userId())
                                   ->where('comment_id', $commentId)
                                   ->first();
        if ($comment instanceof Comment) {
            return $comment;
        }
        return  false;
    }

    public function checkOwnOrFail(int $commentId)
    {
        $comment = $this->checkOwn($commentId);
        if ($comment === false) {
            throw new HyperfCommonException(ErrorCode::NOT_OWN_BY_CURRENT_USER);
        }
        return $comment;
    }

    public function delete(int $commentId)
    {
        $comment = $this->checkOwnOrFail($commentId);
        $postId = $comment->post_id;
        $comment->delete();

        //更新帖子统计信息
        $this->queueService->updatePost($postId);

        return $this->success();
    }

    public function getList(int $postId, int $pageIndex, int $pageSize, int $sortType)
    {
        $list = Comment::query()->where('post_id', $postId)
                                ->where(function (Builder $query) use ($sortType) {
                                    switch ($sortType) {
                                        case Constants::COMMENT_SORT_TYPE_LATEST:
                                            $query->orderBy('created_at','DESC');
                                            break;
                                        case Constants::COMMENT_SORT_TYPE_REPLY_COUNT:
                                            $query->orderBy('reply_count','DESC');
                                            break;
                                        case Constants::COMMENT_SORT_TYPE_PRAISE_COUNT:
                                            $query->orderBy('praise_count','DESC');
                                            break;
                                    }
                                })
                                ->with(['parent_comment'])
                                ->offset($pageIndex * $pageSize)
                                ->limit($pageSize)
                                ->get();
        $total = Comment::query()->where('post_id', $postId)
                                 ->count();
        return [
            'total' => $total,
            'list' => $list
        ];
    }

    public function reply(int $commentId, string $content, array $imageList = null, string $link = null)
    {
        $parentComment = Comment::findOrFail($commentId);
        $comment = new Comment();
        $comment->parent_comment_id = $commentId;
        $comment->parent_comment_owner_id = $parentComment->owner_id;
        $comment->content = $content;
        if (isset($imageList)) {
            $comment->image_list = implode(';', $imageList);
        }
        if (isset($link)) {
            $comment->link = $link;
        }
        $comment->owner_id = $this->userId();
        $comment->post_id = $parentComment->post_id;
        $comment->saveOrFail();

        //更新帖子统计信息
        $this->queueService->updatePost($comment->post_id);

        return $this->success($comment);
    }

    public function getUserCommentList(int $pageIndex, int $pageSize)
    {
        $list = Comment::query()->where('owner_id', $this->userId())
                                ->with(['post','parent_comment'])
                                ->offset($pageIndex * $pageSize)
                                ->limit($pageSize)
                                ->get();
        $total = Comment::query()->where('owner_id', $this->userId())
                                 ->count();
        return ['list'=>$list, 'total'=>$total];
    }

    public function praise(int $commentId)
    {
        Comment::findOrFail($commentId)->increment('praise_count');
        return $this->success();
    }

    public function commentReplyList(int $commentId, int $pageIndex, int $pageSize)
    {
        $list = Comment::query()->where('parent_comment_id', $commentId)
                                ->latest()
                                ->offset($pageIndex * $pageSize)
                                ->limit($pageSize);
        $total = Comment::query()->where('parent_comment_id', $commentId)->count();
        return ['total'=>$total, 'list'=>$list];
    }

    public function userReplyList(int $pageIndex, int $pageSize)
    {
        $list = Comment::query()->where('parent_comment_owner_id', $this->userId())
            ->orWhere('post_owner_id')
            ->latest()
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize);
        $total = Comment::query()->where('parent_comment_owner_id', $this->userId())->count();
        $idList = $list->pluck('comment_id');
        return ['total'=>$total, 'list'=>$list, 'id_list'=>$idList];
    }

    public function reportComment(int $commentId, string $content)
    {
        $report = new ReportComment();
        $report->comment_id = $commentId;
        $report->content = $content;
        $report->owner_id = $this->userId();
        $report->saveOrFail();
        return $this->success();
    }

    public function markRead(array $commentIds)
    {
        Comment::query()->whereIn('comment_id', $commentIds)
                        ->update(['parent_comment_owner_is_read'=>Constants::STATUS_DONE]);
    }
}