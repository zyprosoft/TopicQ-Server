<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $voucher_id 
 * @property int $policy_id 批次ID
 * @property string $voucher_sn 代金券编码
 * @property int $status 0待适用1已使用-1已作废
 * @property int $owner_id 归属者ID,为0的时候说明没有归属，可以后续绑定
 * @property int $left_amount 剩余面值单位分
 * @property string $begin_time 生效开始时间，绑定归属者之后产生
 * @property string $end_time 过期时间，绑定归属者之后产生
 * @property string $used_time 使用时间，多次使用为最后一次使用时间
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at
 * @property-read \App\Model\VoucherPolicy $policy 
 */
class Voucher extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'voucher';
    protected $primaryKey = 'voucher_id';
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
    protected $casts = ['voucher_id' => 'integer', 'activity_id' => 'integer', 'policy_id' => 'integer', 'policy_goods_id' => 'integer', 'policy_black_id' => 'integer', 'status' => 'integer', 'owner_id' => 'integer', 'left_amount' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
    protected $with = ['policy'];

    public function policy()
    {
        return $this->hasOne(VoucherPolicy::class, 'policy_id', 'policy_id');
    }
}