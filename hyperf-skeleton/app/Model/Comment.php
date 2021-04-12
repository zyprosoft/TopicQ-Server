<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $comment_id 
 * @property int $post_id 帖子ID
 * @property int $parent_comment_id 回复的评论
 * @property int $parent_comment_owner_id 原评论的作者ID
 * @property int $owner_id 作者ID
 * @property string $content 回复内容
 * @property string $link 回复的超链接
 * @property string $image_list 回复的图片列表
 * @property int $praise_count 点赞数量
 * @property int $reply_count 回复数量
 * @property int $audit_status 0审核中1:审核通过-1:审核不通过
 * @property string $audit_note 审核备注
 * @property int $is_hot 是否热评，0否1是
 * @property int $post_owner_id 帖子作者ID
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \App\Model\User $author 
 * @property-read \App\Model\Comment $parent_comment 
 * @property-read \App\Model\Post $post 
 */
class Comment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comment';
    protected $primaryKey = 'comment_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['comment_id' => 'integer', 'post_id' => 'integer', 'parent_comment_id' => 'integer', 'parent_comment_owner_id' => 'integer', 'owner_id' => 'integer', 'praise_count' => 'integer', 'reply_count' => 'integer', 'audit_status' => 'integer', 'is_hot' => 'integer', 'post_owner_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
    protected $with = ['author'];
    public function parent_comment()
    {
        return $this->hasOne(Comment::class, 'comment_id', 'parent_comment_id');
    }
    public function post()
    {
        return $this->hasOne(Post::class, 'post_id', 'post_id');
    }
    public function author()
    {
        return $this->hasOne(User::class, 'user_id', 'owner_id');
    }
}