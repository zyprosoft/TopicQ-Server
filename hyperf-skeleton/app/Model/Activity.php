<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $activity_id 
 * @property int $post_id 如果是帖子设为活动
 * @property string $jump_path 内部跳转链接,三种类型必须要有一种
 * @property string $jump_url 跳转H5页面
 * @property string $title 标题
 * @property string $introduce 简介
 * @property string $image 活动图片
 * @property int $creator 活动创建者
 * @property int $sort_index 排序索引
 * @property int $status 0正常-1停止
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 */
class Activity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activity';

    protected $primaryKey = 'activity_id';

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
    protected $casts = ['activity_id' => 'integer', 'post_id' => 'integer', 'creator' => 'integer', 'sort_index' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}