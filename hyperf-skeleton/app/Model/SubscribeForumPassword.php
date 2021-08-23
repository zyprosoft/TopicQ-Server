<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $policy_id 
 * @property string $introduce 本次授权的介绍
 * @property string $sn_prefix 本次发布的授权码前缀
 * @property int $forum_id 绑定的板块
 * @property int $status 0待领取1已领完-1已作废
 * @property int $price 钥匙串价值单位分0不重要>0需要显示
 * @property int $total_count 总共可以生成多少张授权
 * @property int $left_count 剩余多少张可授权
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 * @property-read \App\Model\Forum $forum 
 */
class SubscribeForumPassword extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subscribe_forum_password';
    protected $primaryKey = 'policy_id';
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
    protected $casts = ['id' => 'int', 'forum_id' => 'integer', 'status' => 'integer', 'owner_id' => 'integer', 'price' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'policy_id' => 'integer', 'total_count' => 'integer', 'left_count' => 'integer'];
    protected $with = ['forum'];
    public function forum()
    {
        return $this->hasOne(Forum::class, 'forum_id', 'forum_id');
    }
}