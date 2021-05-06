<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $shop_id 店铺ID
 * @property string $summary_info 汇总信息
 * @property int $type 汇总类型0:未发货1:已发货2:已完成
 * @property int $order_total 该类型总订单数
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 */
class ShopOrderSummary extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shop_order_summary';
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
    protected $casts = ['id' => 'int', 'shop_id' => 'integer', 'type' => 'integer', 'order_total' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}