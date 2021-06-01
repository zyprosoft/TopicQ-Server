<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $red_bag_id 
 * @property string $name 红包名字
 * @property string $desc 红包描述
 * @property int $amount 红包金额，单位分
 * @property int $slice_count 分多少个
 * @property int $is_average 是否平分金额
 * @property string $order_no 支付订单号,非钱包支付的时候有这个
 * @property string $pay_type 支付方式,钱包或者微信等,默认微信
 * @property int $finish_slice 是否分割完成
 * @property int $status 红包状态0正常-1失效
 * @property int $time_span 时效,为0的时候说明没有过期时间
 * @property string $time_unit 时间单位p分钟h小时d天m月y年
 * @property int $creator 创建红包的人
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class RedBag extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'red_bag';

    protected $primaryKey = 'red_bag_id';

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
    protected $casts = ['red_bag_id' => 'integer', 'amount' => 'integer', 'slice_count' => 'integer', 'is_average' => 'integer', 'finish_slice' => 'integer', 'status' => 'integer', 'time_span' => 'integer', 'creator' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}