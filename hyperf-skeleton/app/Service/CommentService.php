<?php


namespace App\Service;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Model\Comment;
use Doctrine\DBAL\Query\QueryBuilder;
use ZYProSoft\Exception\HyperfCommonException;

class CommentService extends BaseService
{
    public function create(string $content, array $imageList = null)
    {
        $comment = new Comment();
        $comment->content = $content;
        $comment->owner_id = $this->userId();
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
        if (!$comment instanceof Comment) {
            return false;
        }
        return  true;
    }

    public function checkOwnOrFail(int $commentId)
    {
        $isOwn = $this->checkOwn($commentId);
        if (!$isOwn) {
            throw new HyperfCommonException(ErrorCode::NOT_OWN_BY_CURRENT_USER);
        }
    }

    public function delete(int $commentId)
    {
        $this->checkOwnOrFail($commentId);
        Comment::findOrFail($commentId)->delete();
        return $this->success();
    }

    public function getList(int $postId, int $pageIndex, int $pageSize, int $sortType)
    {
        $list = Comment::query()->where('post_id', $postId)
                                ->where(function (QueryBuilder $query) use ($sortType) {
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

    public function reply(int $commentId, string $content, array $imageList)
    {
        $parentComment = Comment::findOrFail($commentId);
        $comment = new Comment();
        $comment->parent_comment_id = $commentId;
        $comment->parent_comment_owner_id = $parentComment->owner_id;
        $comment->content = $content;
        $comment->image_list = implode(';', $imageList);
        $comment->owner_id = $this->userId();
        $comment->saveOrFail();
        return $this->success($comment);
    }
}