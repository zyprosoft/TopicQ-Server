<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $group_id 
 * @property string $name 分组名称
 * @property string $label_color 标签颜色
 * @property int $open_choose 是否公开给用户选择,非公开的需要管理员设置
 * @property int $need_real_name 是否需要实名才可绑定
 * @property int $creator 创建者ID
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class UserGroup extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_group';
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
    protected $casts = ['group_id' => 'integer', 'open_choose' => 'integer', 'need_real_name' => 'integer', 'creator' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}