<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property string $sign_date 签到日期
 * @property int $user_id 签到用户
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 * @property int $reward_score 当日签到抽奖积分
 */
class UserDaySign extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_day_sign';
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
    protected $casts = ['id' => 'int', 'user_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'reward_score' => 'integer'];
}