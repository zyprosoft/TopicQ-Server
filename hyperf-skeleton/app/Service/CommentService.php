<?php


namespace App\Service;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Job\CommentMachineAuditJob;
use App\Model\Comment;
use App\Model\Post;
use App\Model\ReportComment;
use App\Model\User;
use App\Model\UserCommentPraise;
use App\Model\UserCommentRead;
use Hyperf\Database\Model\Collection;
use Hyperf\DbConnection\Db;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Facade\Auth;
use ZYProSoft\Log\Log;

class CommentService extends BaseService
{
    //重载获取当前用户ID的方法
    protected function userId()
    {
        //当前用户是不是管理员
        if (Auth::isGuest()) {
            return Auth::userId();
        }
        $userId = Auth::userId();
        $user = User::find($userId);
        if ($user->role_id == Constants::USER_ROLE_ADMIN) {
            //检查是不是在使用化身
            if ($user->avatar_user_id > 0) {
                Log::info("使用化身($user->avatar_user_id)");
                return $user->avatar_user_id;
            }
        }
        return $userId;
    }

    public function create(int $postId, string $content = null, array $imageList = null, string $link = null)
    {
        $post = Post::findOrFail($postId);

        $comment = new Comment();
        $comment->owner_id = $this->userId();
        $comment->post_id = $postId;
        $comment->post_owner_id = $post->owner_id;
        if (isset($link)) {
            $comment->link = $link;
        }
        if(isset($content)) {
            $comment->content = $content;
        }

        $imageAuditCheck = [
            'need_audit' => false,
            'need_review' => false
        ];
        if (isset($imageList)) {
            if(!empty($imageList)) {
                $comment->image_list = implode(';', $imageList);
                $imageIds = $this->imageIdsFromUrlList($imageList);
                $comment->image_ids = implode(';',$imageIds);
                //审核图片
                $imageAuditCheck = $this->auditImageOrFail($imageList);
            }
        }

        if($imageAuditCheck['need_review']) {
            $comment->machine_audit = Constants::STATUS_REVIEW;
        }
        $comment->saveOrFail();

        //更新帖子统计信息
        $this->queueService->updatePost($postId);

        $this->queueService->updateUser($post->owner_id);

        //加入评论异步审核任务
        $this->push(new CommentMachineAuditJob($comment->comment_id));

        //更新热门评论列表
        $this->queueService->updateCommentHot($postId);

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
        return false;
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
        if($sortType == Constants::COMMENT_SORT_TYPE_ONLY_POST_OWNER) {
            $post = Post::findOrFail($postId);
            $list = Comment::query()->where('post_id', $postId)
                ->where('owner_id', $post->owner_id)
                ->with(['parent_comment'])
                ->offset($pageIndex * $pageSize)
                ->limit($pageSize)
                ->get();
        }elseif ($sortType == Constants::COMMENT_SORT_TYPE_POST_EARLY) {
            //正常顺序，最早发表
            $list = Comment::query()->where('post_id', $postId)
                ->with(['parent_comment'])
                ->offset($pageIndex * $pageSize)
                ->limit($pageSize)
                ->get();
        }
        else{
            $map = [
                Constants::COMMENT_SORT_TYPE_LATEST => 'created_at',
                Constants::COMMENT_SORT_TYPE_REPLY_COUNT => 'reply_count',
                Constants::COMMENT_SORT_TYPE_PRAISE_COUNT => 'praise_count',
            ];
            $order = $map[$sortType];
            $list = Comment::query()->where('post_id', $postId)
                ->orderByDesc($order)
                ->with(['parent_comment'])
                ->offset($pageIndex * $pageSize)
                ->limit($pageSize)
                ->get();
        }

        //转换图片数组格式
        $this->changeImageList($list);
        
        //是否点赞
        $this->addPraiseStatus($list);

        //第一页返回热门评论
        $hotList = null;
        if($pageIndex == 0) {
            $hotList = Comment::query()->where('post_id', $postId)
                                       ->where('is_hot', Constants::STATUS_DONE)
                                       ->with(['parent_comment'])
                                       ->get();
            $this->addPraiseStatus($hotList);
        }
        
        $total = Comment::query()->where('post_id', $postId)
            ->count();
        $result = [
            'total' => $total,
            'list' => $list
        ];
        if (isset($hotList)) {
            $result['hot_list'] = $hotList;
        }
        return $result;
    }

    public function reply(int $commentId, string $content = null, array $imageList = null, string $link = null)
    {
        $parentComment = Comment::findOrFail($commentId);
        $comment = new Comment();
        $comment->parent_comment_id = $commentId;
        $comment->parent_comment_owner_id = $parentComment->owner_id;
        if(isset($content)) {
            $comment->content = $content;
        }
        $imageAuditCheck = [
            'need_audit' => false,
            'need_review' => false
        ];
        if (isset($imageList)) {
            if(!empty($imageList)) {
                $comment->image_list = implode(';', $imageList);
                $imageIds = $this->imageIdsFromUrlList($imageList);
                $comment->image_ids = implode(';',$imageIds);
                //审核图片
                $imageAuditCheck = $this->auditImageOrFail($imageList);
            }
        }
        if (isset($link)) {
            $comment->link = $link;
        }
        $comment->owner_id = $this->userId();
        $comment->post_id = $parentComment->post_id;
        $comment->post_owner_id = $parentComment->post_owner_id;
        if($imageAuditCheck['need_review']) {
            $comment->machine_audit = Constants::STATUS_REVIEW;
        }
        $comment->saveOrFail();

        //读取数据库完整的帖子信息
        $comment = Comment::query()->where('comment_id', $comment->comment_id)
                                   ->with(['parent_comment'])
                                   ->first();
        if (!$comment instanceof Comment) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }
        $comment->is_praise = 0;
        //图片转数组
        $this->changeImageListByComment($comment);

        //更新帖子统计信息
        $this->queueService->updatePost($comment->post_id);
        
        //更新评论信息
        $this->queueService->updateComment($parentComment->comment_id);

        //加入评论异步审核任务,评论也没有人工审核机制
        $this->push(new CommentMachineAuditJob($comment->comment_id));

        //更新热门评论列表
        $this->queueService->updateCommentHot($comment->post_id);

        return $this->success($comment);
    }

    protected function changeImageList(Collection &$list, bool $needChangeParentComment = true)
    {
        $list->map(function (Comment $comment) use ($needChangeParentComment) {
            if (isset($comment->image_list) && is_string($comment->image_list)) {
                $comment->image_list = explode(';', $comment->image_list);
            }
            if($needChangeParentComment) {
                if (isset($comment->parent_comment) && isset($comment->parent_comment->image_list) && is_string($comment->parent_comment->image_list)) {
                    $comment->parent_comment->image_list = explode(';', $comment->parent_comment->image_list);
                }
            }
            return $comment;
        });
    }

    protected function addPraiseStatus(Collection &$list)
    {
        //是否点赞
        if(Auth::isGuest() == false) {
            $commentIds = $list->pluck('comment_id');
            $praiseList = UserCommentPraise::query()->where('user_id', $this->userId())
                ->whereIn('comment_id', $commentIds)
                ->get()
                ->keyBy('comment_id');
            $list->map(function (Comment  $comment) use ($praiseList) {
                $comment->is_praise = isset($praiseList[$comment->comment_id])?1:0;
                return $comment;
            });
        }else{
            $list->map(function (Comment  $comment) {
                $comment->is_praise = 0;
                return $comment;
            });
        }
    }

    public function getUserCommentList(int $pageIndex, int $pageSize, int $userId = null)
    {
        if (!isset($userId)) {
            $userId = $this->userId();
        }
        $list = Comment::query()->where('owner_id', $userId)
            ->with(['post', 'parent_comment'])
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->latest()
            ->get();

        //转换图片数组格式
        $this->changeImageList($list);

        //是否点赞
        $this->addPraiseStatus($list);

        $total = Comment::query()->where('owner_id', $userId)
            ->count();
        return ['list' => $list, 'total' => $total];
    }

    public function praise(int $commentId)
    {
        Db::transaction(function () use ($commentId){
            $praise = UserCommentPraise::query()->where('user_id', $this->userId())
                ->where('comment_id',$commentId)
                ->first();
            if ($praise instanceof UserCommentPraise) {
                $praise->delete();
                Comment::findOrFail($commentId)->decrement('praise_count');
                return  $this->success();
            }
            $comment = Comment::findOrFail($commentId);
            $praise = new UserCommentPraise();
            $praise->user_id = $this->userId();
            $praise->comment_id = $commentId;
            $praise->comment_owner_id = $comment->owner_id;
            $praise->saveOrFail();
            Comment::findOrFail($commentId)->increment('praise_count');
        });
        return $this->success();
    }

    public function commentReplyList(int $commentId, int $pageIndex, int $pageSize)
    {
        $list = Comment::query()->where('parent_comment_id', $commentId)
            ->with(['post'])
            ->latest()
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();
        //转换图片数组格式
        $this->changeImageList($list,false);
        //是否点赞
        $this->addPraiseStatus($list);
        $total = Comment::query()->where('parent_comment_id', $commentId)->count();
        return ['total' => $total, 'list' => $list];
    }

    protected function isPraised(int $commentId)
    {
        if (Auth::isGuest() == false) {
            $praise = UserCommentPraise::query()->where('user_id', $this->userId())
                                                ->where('comment_id', $commentId)
                                                ->first();
            return  $praise instanceof UserCommentPraise;
        }
        return false;
    }

    protected function changeImageListByComment(Comment &$comment)
    {
        if (isset($comment->image_list) && is_string($comment->image_list)) {
            $comment->image_list = explode(';', $comment->image_list);
        }
        if (isset($comment->parent_comment) &&
            isset($comment->parent_comment->image_list) &&
            is_string($comment->parent_comment->image_list)) {
            $comment->parent_comment->image_list = explode(';', $comment->parent_comment->image_list);
        }
    }

    public function detail(int $commentId)
    {
        $comment = Comment::query()->where('comment_id', $commentId)
                                   ->with(['parent_comment'])
                                   ->first();
        if (!$comment instanceof Comment) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_DID_EXIST);
        }
        //是否已经点赞
        $comment->is_praise = $this->isPraised($commentId)?1:0;
        //改变图片
        $this->changeImageListByComment($comment);
        return $comment;
    }

    public function userReplyList(int $pageIndex, int $pageSize)
    {
        $list = Comment::query()->where('parent_comment_owner_id', $this->userId())
            ->orWhere('post_owner_id', $this->userId())
            ->with(['post'])
            ->latest()
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();
        //转换图片数组格式
        $this->changeImageList($list);
        //是否点赞
        $this->addPraiseStatus($list);
        $total = Comment::query()->where('parent_comment_owner_id', $this->userId())
            ->orWhere('post_owner_id', $this->userId())
            ->count();
        //找出未读的Id列表
        $idList = $list->pluck('comment_id');
        $unreadIds = [];
        if(!empty($idList)) {
            $readStatusList = UserCommentRead::query()->whereIn('comment_id', $idList)
                ->where('user_id', $this->userId())
                ->get()
                ->keyBy('comment_id');
            $idList->map(function (int $commentId) use (&$unreadIds, $readStatusList){
                if (!isset($readStatusList[$commentId])) {
                    $unreadIds[] = $commentId;
                }
            });
        }

        return ['total' => $total, 'list' => $list, 'id_list' => $unreadIds];
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
        $list = [];
        collect($commentIds)->map(function (int $commentId) use (&$list) {
            $list[] = [
                'user_id' => $this->userId(),
                'comment_id' => $commentId
            ];
        });
        Db::table('user_comment_read')->insertOrIgnore($list);
        return $this->success();
    }

    public function praiseList(int $pageIndex, int $pageSize)
    {
        $list = UserCommentPraise::query()->where('comment_owner_id', $this->userId())
                                          ->with(['comment','author'])
                                          ->offset($pageIndex * $pageSize)
                                          ->limit($pageSize)
                                          ->latest()
                                          ->get();
        //带上帖子信息
        $commentIds = $list->pluck('comment_id');
        $commentList = Comment::query()->whereIn('comment_id', $commentIds)
                                       ->with(['post'])
                                       ->get()
                                       ->keyBy('comment_id');
        $list->map(function (UserCommentPraise $praise) use ($commentList) {
             $comment = $commentList->get($praise->comment_id);
             if(isset($comment)) {
                 if (isset($praise->comment->image_list) && is_string($comment->image_list)) {
                     $praise->comment->image_list = explode(';', $comment->image_list);
                 }
                 if(isset($comment->post)) {
                     $praise->post = [
                         'post_id' => $comment->post_id,
                         'title' => $comment->post->title
                     ];
                 }
             }
             return $praise;
        });

        //找出未读Id列表
        $unreadIds = $list->where('owner_read_status',0)->pluck('id');
        $total = UserCommentPraise::query()->where('comment_owner_id', $this->userId())->count();
        return ['total'=>$total,'list'=>$list,'id_list'=> $unreadIds];
    }

    public function markPraiseRead(array $praiseIds)
    {
        UserCommentPraise::query()->whereIn('id', $praiseIds)
                                  ->where('comment_owner_id', $this->userId())
                                  ->update(['owner_read_status'=>1]);
        return $this->success();
    }
}