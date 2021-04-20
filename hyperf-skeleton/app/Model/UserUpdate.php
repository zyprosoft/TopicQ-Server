<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $update_id 
 * @property int $user_id 用户ID
 * @property string $avatar 头像
 * @property string $background 背景
 * @property string $nickname 昵称
 * @property int $machine_audit 机器审核结果:0待审核-1不通过1通过2建议人工复核
 * @property int $manager_audit 管理员审核结果:0待审核-1不通过1通过
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class UserUpdate extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_update';
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
    protected $casts = ['update_id' => 'integer', 'user_id' => 'integer', 'machine_audit' => 'integer', 'manager_audit' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}