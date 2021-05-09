<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $policy_black_id 
 * @property string $category_list 拉黑产品类别，多个ID使用逗号分割,没有goods_list的时候说明是类别下全部拉黑
 * @property string $goods_list 拉黑具体产品，当有指定产品列表的时候，就不存在为类别全部拉黑
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 * @property-read \App\Model\VoucherPolicy $policy 
 */
class VoucherPolicyBlackGood extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'voucher_policy_black_goods';
    protected $primaryKey = 'policy_black_id';
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
    protected $casts = ['policy_black_id' => 'integer', 'activity_id' => 'integer', 'policy_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
    public function policy()
    {
        return $this->hasOne(VoucherPolicy::class, 'policy_id', 'policy_id');
    }
    public function category_items()
    {
        if (empty($this->category_list)) {
            return [];
        }
        $categoryIds = explode(',', $this->category_list);
        return GoodsCategory::findMany($categoryIds);
    }
    public function goods_items()
    {
        if (empty($this->goods_list)) {
            return [];
        }
        $goodsIds = explode(',', $this->goods_list);
        return Good::findMany($goodsIds);
    }
}