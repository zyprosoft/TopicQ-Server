<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $order_id 
 * @property string $order_no 订单号
 * @property int $pay_status 订单状态0:未支付1:已支付
 * @property int $deliver_status 送货状态0:未送货1:已送货
 * @property int $owner_id 用户ID
 * @property int $shop_owner_id 店铺用户ID
 * @property int $shop_id 店铺ID
 * @property int $cash 订单金额，单位分
 * @property int $platform_cut 平台抽成，单位分
 * @property string $address 收货地址
 * @property string $mobile 收货人手机号
 * @property string $nickname 收货人昵称
 * @property string $customer_note 客户备注
 * @property int $deliver_type 发货形式0：送货1：自取
 * @property int $receive_status 收货确认0:未确认1:确认
 * @property int $finish_status 完成状态0:未完成1:已完成
 * @property string $finish_note 达到完成状态的备注
 * @property int $is_appreciate 客户是否点赞
 * @property string $deliver_time 发货时间
 * @property string $receive_time 确认收货时间
 * @property int $order_expire 未支付订单过期时间，单位分钟,默认30分钟
 * @property string $wx_prepay_id 微信支付统一订单号
 * @property string $wx_prepay_id_time 微信支付订单号生成时间
 * @property string $pay_status_note 支付状态变更备注
 * @property string $wx_prepay_body 微信支付申请统一订单时候的body
 * @property string $pay_time 支付成功时间
 * @property string $pay_expire_time 未支付状态下的过期时间
 * @property int $is_comment 是否已点评订单0:否1:是
 * @property string $print_order_id 云打印机的返回的编号，如果打印了这个编号存在
 * @property string $print_time 云打印成功的时间
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Order extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order';

    protected $primaryKey = 'order_id';

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
    protected $casts = ['order_id' => 'integer', 'pay_status' => 'integer', 'deliver_status' => 'integer', 'owner_id' => 'integer', 'shop_owner_id' => 'integer', 'shop_id' => 'integer', 'cash' => 'integer', 'platform_cut' => 'integer', 'deliver_type' => 'integer', 'receive_status' => 'integer', 'finish_status' => 'integer', 'is_appreciate' => 'integer', 'order_expire' => 'integer', 'is_comment' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    protected $with = [
        'order_goods',
        'shop'
    ];

    public function order_goods()
    {
        return $this->hasMany(OrderGood::class, 'order_no', 'order_no');
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