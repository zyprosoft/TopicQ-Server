<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $subscribe_id 
 * @property int $user_id 用户ID
 * @property int $forum_id 板块ID
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class UserSubscribe extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_subscribe';
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
    protected $casts = ['subscribe_id' => 'integer', 'user_id' => 'integer', 'forum_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}