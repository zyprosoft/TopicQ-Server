<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $user_id 用户ID
 * @property int $comment_id 评论ID
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
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
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'comment_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}