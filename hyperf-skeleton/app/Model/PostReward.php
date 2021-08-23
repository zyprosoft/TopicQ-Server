<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $reward_id 
 * @property int $owner_id 谁打赏的
 * @property int $post_id 打赏的哪个帖子
 * @property int $post_owner_id 打赏帖子的作者
 * @property int $amount 打赏的金额单位分
 * @property string $order_no 打赏时候的订单号,非钱包支付
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class PostReward extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_reward';
    protected $primaryKey = 'reward_id';
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
    protected $casts = ['reward_id' => 'integer', 'owner_id' => 'integer', 'post_id' => 'integer', 'post_owner_id' => 'integer', 'amount' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}