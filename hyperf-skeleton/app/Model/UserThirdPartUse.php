<?php

declare (strict_types=1);
namespace App\Model;

use App\Constants\Constants;

/**
 * @property int $id 
 * @property int $user_id 用户ID
 * @property int $third_part_type 第三方使用类型0小程序1公众号
 * @property int $third_part_id 第三方类型ID
 * @property int $count 使用次数
 * @property int $is_outside 是否外显到我的页面,只支持小程序
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 */
class UserThirdPartUse extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_third_part_use';
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
    protected $casts = ['id' => 'int', 'user_id' => 'integer', 'third_part_type' => 'integer', 'third_part_id' => 'integer', 'count' => 'integer', 'is_outside' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];


}