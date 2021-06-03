<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $program_id 
 * @property string $app_id 小程序appId
 * @property string $icon 图标
 * @property string $name 名字
 * @property string $introduce 介绍
 * @property int $category_id 分类ID
 * @property string $owner_name 主体官方名字
 * @property string $address 主体的地址
 * @property string $phone_number 主体的座机
 * @property string $mobile 主体的手机信息
 * @property string $owner_contact_name 主体联系人名字
 * @property string $open_time 主体的经营时间
 * @property int $create_user_id 创建者ID
 * @property int $update_user_id 更新者ID
 * @property string $index_path 跳转路径
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class QqMiniProgram extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'qq_mini_program';
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
    protected $casts = ['program_id' => 'integer', 'category_id' => 'integer', 'create_user_id' => 'integer', 'update_user_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}