<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $user_id 打赏人
 * @property int $post_owner_id 被打赏
 * @property int $post_id 打赏的帖子或者动态
 * @property int $amount 数量
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class PostScoreReward extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_score_reward';
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
    protected $casts = ['id' => 'int', 'user_id' => 'integer', 'post_owner_id' => 'integer', 'post_id' => 'integer', 'amount' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function author()
    {
        return $this->hasOne(User::class,'user_id','user_id');
    }
}