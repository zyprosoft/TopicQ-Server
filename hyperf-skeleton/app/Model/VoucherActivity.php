<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $activity_id 
 * @property string $name 活动名称
 * @property string $introduce 活动介绍
 * @property string $image_list 活动图片
 * @property int $create_user 创建者ID
 * @property string $begin_time 开始时间
 * @property string $end_time 结束时间
 * @property int $status 0正常-1失效
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 */
class VoucherActivity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'voucher_activity';
    protected $primaryKey = 'activity_id';
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
    protected $casts = ['activity_id' => 'integer', 'create_user' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}