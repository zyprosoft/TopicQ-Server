<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $policy_goods_id 
 * @property int $activity_id 活动ID
 * @property int $policy_id 批次ID
 * @property string $category_list 适用产品类别，多个ID使用逗号分割,没有goods_list的时候说明是类别适用
 * @property string $goods_list 适用具体产品，当有指定产品列表的时候，就不存在为类别通用
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 */
class VoucherPolicyGood extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'voucher_policy_goods';
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
    protected $casts = ['policy_goods_id' => 'integer', 'activity_id' => 'integer', 'policy_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}