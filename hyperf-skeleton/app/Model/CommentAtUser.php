<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $comment_id 评论ID
 * @property int $user_id 用户ID
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class CommentAtUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comment_at_user';
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
    protected $casts = ['id' => 'int', 'comment_id' => 'integer', 'user_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}