<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property string $bind_action 绑定行为
 * @property int $owner_id 用户
 * @property int $score 变化分数
 * @property string $desc 加分描述
 * @property string $key_info 携带信息json
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 */
class UserScoreDetail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_score_detail';
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
    protected $casts = ['id' => 'int', 'owner_id' => 'integer', 'score' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}