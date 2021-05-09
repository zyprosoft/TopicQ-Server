<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $policy_id 
 * @property int $activity_id 归属活动
 * @property string $sn_prefix 本批次授权码前缀
 * @property int $total_count 总授权数量
 * @property int $amount 券的面值，单位分
 * @property int $left_count 剩余可授权数量
 * @property int $multi_use 是否可以多次使用0否1是
 * @property int $base_amount 大于0的时候为满减0为无门槛
 * @property int $time_span 0为永久生效大于0则看生效单位
 * @property string $time_unit 与time_span配合使用p:分钟h:小时d:天m:月y:年
 * @property int $status 0待生效1已生效-1已作废
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 * @property int $policy_goods_id 适用商品ID,没有为全部适用
 * @property int $policy_black_id 不适用商品ID,没有为不拉黑
 * @property-read \App\Model\VoucherActivity $activity 
 * @property-read \App\Model\VoucherPolicyBlackGood $black_goods 
 * @property-read \App\Model\VoucherPolicyGood $goods 
 */
class VoucherPolicy extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'voucher_policy';
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
    protected $casts = ['policy_id' => 'integer', 'activity_id' => 'integer', 'total_count' => 'integer', 'amount' => 'integer', 'left_count' => 'integer', 'multi_use' => 'integer', 'base_amount' => 'integer', 'time_span' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'policy_goods_id' => 'integer', 'policy_black_id' => 'integer'];
    protected $with = ['activity', 'goods', 'black_goods'];
    public function activity()
    {
        return $this->hasOne(VoucherActivity::class, 'activity_id', 'activity_id');
    }
    public function goods()
    {
        return $this->hasOne(VoucherPolicyGood::class, 'policy_id', 'policy_id');
    }
    public function black_goods()
    {
        return $this->hasOne(VoucherPolicyBlackGood::class, 'policy_id', 'policy_id');
    }
}