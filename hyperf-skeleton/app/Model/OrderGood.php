<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property string $order_no 
 * @property int $goods_id 商品ID
 * @property string $order_goods_name 下单时商品名字
 * @property string $order_goods_image 下单时商品图片
 * @property int $count 数量
 * @property int $order_price 购买时候的定价
 * @property string $order_unit 购买时的单位
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class OrderGood extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_goods';

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
    protected $casts = ['id' => 'int', 'goods_id' => 'integer', 'count' => 'integer', 'order_price' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}