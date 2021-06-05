<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $user_id 用户ID
 * @property int $post_id 帖子ID
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property int $owner_read_status 帖主已读状态
 */
class UserPraisePost extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_praise_post';
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
    protected $casts = ['id' => 'int', 'user_id' => 'integer', 'post_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'owner_read_status' => 'integer'];
}