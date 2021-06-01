<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $owner_id 行为用户
 * @property int $type 行为0:支出1:收入2:提现
 * @property int $cash 金额，单位分
 * @property int $platform_cut 收入时候平台抽成
 * @property string $order_no 关联的订单
 * @property string $note 备注
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class CashLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cash_log';
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
    protected $casts = ['id' => 'int', 'owner_id' => 'integer', 'type' => 'integer', 'cash' => 'integer', 'platform_cut' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}