<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $category_id 
 * @property string $name 分类名称
 * @property string $icon 分类图标
 * @property int $total 当前分类下总数
 * @property int $create_user_id 创建者
 * @property int $update_user_id 更新者
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class MiniProgramCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mini_program_category';

    protected $primaryKey = 'category_id';

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
    protected $casts = ['category_id' => 'integer', 'total' => 'integer', 'create_user_id' => 'integer', 'update_user_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}