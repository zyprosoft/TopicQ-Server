<?php


namespace App\Service;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Model\Comment;
use Hyperf\Database\Query\Builder;
use ZYProSoft\Exception\HyperfCommonException;

class CommentService extends BaseService
{
    public function create(int $postId, string $content, array $imageList = null, string $link = null)
    {
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
        $comment->delete();
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
        return $this->success($comment);
    }

    public function getUserCommentList(int $pageIndex, int $pageSize)
    {
        $list = Comment::query()->where('owner_id', $this->userId())
                                ->with(['post', 'author'])
                                ->offset($pageIndex * $pageSize)
                                ->limit($pageSize)
                                ->get();
        $total = Comment::query()->where('owner_id', $this->userId())
                                 ->count();
        return ['list'=>$list, 'total'=>$total];
    }
}