<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property string $unlock_sn_no 解锁的密钥串
 * @property int $forum_id 绑定的板块
 * @property int $status 0未使用1已使用
 * @property int $owner_id 被谁领取了
 * @property int $price 钥匙串价值单位分0不重要>0需要显示
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 */
class SubscribeForumPassword extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subscribe_forum_password';
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
    protected $casts = ['id' => 'int', 'forum_id' => 'integer', 'status' => 'integer', 'owner_id' => 'integer', 'price' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}