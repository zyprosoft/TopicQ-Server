<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $cut_id 
 * @property string $code 抽成的代码
 * @property string $name 抽成项目名字
 * @property string $desc 抽成描述
 * @property int $percentage 抽成百分比
 * @property int $update_user 更新的用户
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class PlatformCut extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'platform_cut';

    protected $primaryKey = 'cut_id';

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
    protected $casts = ['cut_id' => 'integer', 'percentage' => 'integer', 'update_user' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}