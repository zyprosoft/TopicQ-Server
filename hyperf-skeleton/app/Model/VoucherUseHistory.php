<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $owner_id 归属者
 * @property string $voucher_sn 券编码
 * @property int $voucher_id 券ID
 * @property int $amount 金额
 * @property int $type 0扣减1:回滚
 * @property string $order_no 使用时候的订单号
 * @property int $order_id 订单编号
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 * @property-read \App\Model\VoucherPolicyBlackGood $black_goods 
 * @property-read \App\Model\VoucherPolicyGood $goods 
 * @property-read \App\Model\VoucherPolicy $policy 
 */
class VoucherUseHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'voucher_use_history';
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
    protected $casts = ['id' => 'int', 'owner_id' => 'integer', 'policy_id' => 'integer', 'policy_goods_id' => 'integer', 'policy_black_id' => 'integer', 'amount' => 'integer', 'type' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'voucher_id' => 'integer', 'order_id' => 'integer'];

    protected $with = [
        'voucher',
        'order'
    ];

    public function voucher()
    {
        return $this->hasOne(Voucher::class,'voucher_id','voucher_id');
    }

    public function order()
    {
        return $this->hasOne(Order::class,'order_id','order_id');
    }
}