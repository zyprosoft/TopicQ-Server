<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $topic_id 
 * @property string $title 话题标题
 * @property string $introduce 话题介绍
 * @property int $owner_id 谁创建的
 * @property string $image 图片
 * @property string $location 位置
 * @property int $category_id 分类
 * @property int $read_count 阅读数
 * @property int $join_count 参与人数
 * @property int $post_count 帖子数
 * @property int $comment_count 评论数
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 */
class Topic extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'topic';

    protected $primaryKey = 'topic_id';

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
    protected $casts = ['topic_id' => 'integer', 'owner_id' => 'integer', 'category_id' => 'integer', 'read_count' => 'integer', 'join_count' => 'integer', 'post_count' => 'integer', 'comment_count' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}