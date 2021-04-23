<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $user_id 用户ID
 * @property int $comment_id 评论ID
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property int $comment_owner_id 评论归属作者
 * @property int $owner_read_status 评论归属者阅读状态
 * @property-read \App\Model\User $author 
 * @property-read \App\Model\Comment $comment 
 */
class UserCommentPraise extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_comment_praise';
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
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'comment_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'comment_owner_id' => 'integer', 'owner_read_status' => 'integer'];
    public function author()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }
    public function comment()
    {
        return $this->hasOne(Comment::class, 'comment_id', 'comment_id');
    }
}