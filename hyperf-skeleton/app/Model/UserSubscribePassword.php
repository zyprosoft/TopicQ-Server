<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property string $unlock_sn 最长64位的解锁码
 * @property int $owner_id 归属谁
 * @property int $status 0待使用1已使用
 * @property int $policy_id 归属哪个批次
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 */
class UserSubscribePassword extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_subscribe_password';
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
    protected $casts = ['id' => 'int', 'owner_id' => 'integer', 'status' => 'integer', 'policy_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    protected $with = [
        'policy'
    ];

    public function policy()
    {
        return $this->hasOne(SubscribeForumPassword::class,'policy_id','policy_id');
    }
}