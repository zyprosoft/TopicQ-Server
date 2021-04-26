<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $forum_id 板块ID
 * @property int $type 0主板块1子板块
 * @property int $parent_forum_id 父板块ID
 * @property string $icon 板块图标
 * @property string $name 板块名称
 * @property string $area 板块归属区县
 * @property string $country 板块归属乡镇
 * @property int $sort_index 排序索引，数字越大优先级越高
 * @property int $total_child_count 子板块总数
 * @property int $total_post_count 帖子总数
 * @property string $notice 板块公告
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 */
class Forum extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'forum';
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
    protected $casts = ['forum_id' => 'integer', 'type' => 'integer', 'parent_forum_id' => 'integer', 'sort_index' => 'integer', 'total_child_count' => 'integer', 'total_post_count' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}