<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property string $bind_action 绑定的行为码
 * @property string $name 行为名称描述
 * @property int $score 积分值默认1
 * @property int $day_once 是否每天限制一次
 * @property int $is_system 是否系统设定的行为
 * @property int $creator 创建者ID,系统初始化的为0
 * @property int $day_max_times 每日加分次数最大限制0为不限制
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class ScoreAction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'score_action';
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
    protected $casts = ['id' => 'int', 'score' => 'integer', 'day_once' => 'integer', 'is_system' => 'integer', 'creator' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'day_max_times' => 'integer'];
}