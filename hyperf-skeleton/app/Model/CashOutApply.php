<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $owner_id 用户ID
 * @property string $mobile 提交者手机号
 * @property int $amount 提现金额，单位分
 * @property int $admin_operate_result 管理员操作结果0:待完成1:已完成-1:驳回请求
 * @property string $reject_reason 如果被驳回了，填充这个字段
 * @property string $admin_operate_note 管理员操作备注
 * @property string $bank_order_info 银行返回的订单信息，如果有的话填充一下
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 */
class CashOutApply extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cash_out_apply';
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
    protected $casts = ['id' => 'int', 'owner_id' => 'integer', 'amount' => 'integer', 'admin_operate_result' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}