<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $user_id 用户ID
 * @property int $program_id 小程序记录ID
 * @property int $count 使用次数
 * @property int $is_outside 是否外显到我的页面
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 * @property string $type 小程序类型
 * @property-read \App\Model\MiniProgram $mini_program 
 */
class UserMiniProgramUse extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_mini_program_use';
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
    protected $casts = ['id' => 'int', 'user_id' => 'integer', 'program_id' => 'integer', 'count' => 'integer', 'is_outside' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
    protected $with = ['mini_program'];
    public function mini_program()
    {
        return $this->hasOne(MiniProgram::class, 'program_id', 'program_id');
    }
}