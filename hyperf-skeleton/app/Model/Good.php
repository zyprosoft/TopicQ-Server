<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $goods_id 
 * @property string $name 商品名称
 * @property int $stock 库存
 * @property int $category_id 商品类目ID
 * @property int $shop_id 店铺ID
 * @property int $owner_id 所有者ID
 * @property int $price 单价,单位分
 * @property string $unit 单位
 * @property string $image 图片
 * @property int $status 商品状态
 * @property int $total_sale_count 总售出数量
 * @property string $labels 标签
 * @property string $desc 商品简介
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property int $bind_forum_id 绑定板块ID
 * @property-read \App\Model\GoodsCategory $category 
 * @property-read \App\Model\User $owner 
 * @property-read \App\Model\Shop $shop 
 */
class Good extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'goods';
    protected $primaryKey = 'goods_id';
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
    protected $casts = ['goods_id' => 'integer', 'stock' => 'integer', 'category_id' => 'integer', 'shop_id' => 'integer', 'owner_id' => 'integer', 'price' => 'integer', 'status' => 'integer', 'total_sale_count' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'bind_forum_id' => 'integer'];
    public function category()
    {
        return $this->hasOne(GoodsCategory::class, 'category_id', 'category_id');
    }
    public function shop()
    {
        return $this->hasOne(Shop::class, 'shop_id', 'shop_id');
    }
    public function owner()
    {
        return $this->hasOne(User::class, 'user_id', 'owner_id');
    }
}