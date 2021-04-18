<?php


namespace App\Service\Admin;
use App\Constants\Constants;
use App\Model\Post;
use App\Service\BaseService;
use Hyperf\Database\Model\Builder;
use Hyperf\DbConnection\Db;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;

class PostService extends BaseService
{
    public function getWaitAuditPostList(int $pageIndex, int $pageSize, int $lastPostId = null)
    {
        $list = Post::query()->where('audit_status',Constants::STATUS_WAIT)
                             ->where(function (Builder $query) use ($lastPostId){
                                 if(isset($lastPostId)) {
                                     $query->where('post_id','<', $lastPostId);
                                 }
                             })
                             ->latest()
                             ->offset($pageIndex * $pageSize)
                             ->limit($pageSize);
        $total = Post::query()->where('audit_status',Constants::STATUS_WAIT)->count();

        return ['total'=>$total, 'list'=>$list];
    }

    public function audit(int $postId, int $status, string $note = null)
    {
        Db::transaction(function () use ($postId, $status, $note){
            $post = Post::query()->where('post_id', $postId)
                ->lockForUpdate()
                ->first();
            if(!$post instanceof Post) {
                throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
            }
            if ($post->audit_status != Constants::STATUS_WAIT) {
                return $this->success();
            }
            $post->audit_status = $status;
            if ((isset($note))) {
                $post->audit_note = $note;
            }
            $post->saveOrFail();
            return $this->success();
        });
        return $this->success();
    }

    protected function postUpdate(int $postId, string $column, int $value)
    {
        Db::transaction(function () use ($postId, $column, $value) {
            $post = Post::query()->where('post_id', $postId)
                ->lockForUpdate()
                ->first();
            if (!$post instanceof Post) {
                throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
            }
            if ($post->audit_status != Constants::STATUS_WAIT) {
                return $this->success();
            }
            $post->$column = $value;
            $post->saveOrFail();
            return $this->success();
        });
        return $this->success();
    }

    public function recommend(int $postId)
    {
        $this->postUpdate($postId,'is_recommend',1);
    }

    public function sortUp(int $postId)
    {
        $this->postUpdate($postId,'sort_index',1);
    }

    public function hot(int $postId)
    {
        $this->postUpdate($postId,'is_hot',1);
    }
}