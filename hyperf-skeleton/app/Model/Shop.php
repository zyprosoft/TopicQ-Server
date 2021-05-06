<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $shop_id 
 * @property string $name 店铺名称
 * @property string $address 店铺地址
 * @property string $introduce 店铺简介
 * @property int $type 店铺类型,默认值0
 * @property int $owner_id 店主用户ID
 * @property int $status 店铺状态,0待发布;-1:拉黑;1:发布
 * @property string $block_reason 拉黑备注
 * @property string $image 店铺图片
 * @property int $base_deliver_price 起送价格,单位分
 * @property int $open_time 开始营业时间,整点,默认0点
 * @property int $close_time 停止营业时间,整点,默认24点关
 * @property string $phone_number 联系电话
 * @property string $avatar_list 最近四个下单用户的头像链接,分号分割
 * @property int $total_customer 总客户数
 * @property int $total_order 总订单数
 * @property string $latest_order_list 最近15单的订单编号列表，用分号分割
 * @property int $wait_deliver_order_count 等待送货订单数量
 * @property string $qr_code 小程序码链接地址
 * @property int $platform_cut 店铺平台特定抽成
 * @property int $audit_status 店铺审核状态-1:不合规0:审核中1:合规
 * @property string $audit_note 店铺审核总体备注
 * @property string $image_id 图片ID
 * @property string $printer_sn 店铺绑定的打印机
 * @property string $printer_key 店铺绑定的打印机的key
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Shop extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shop';
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
    protected $casts = ['shop_id' => 'integer', 'type' => 'integer', 'owner_id' => 'integer', 'status' => 'integer', 'base_deliver_price' => 'integer', 'open_time' => 'integer', 'close_time' => 'integer', 'total_customer' => 'integer', 'total_order' => 'integer', 'wait_deliver_order_count' => 'integer', 'platform_cut' => 'integer', 'audit_status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}