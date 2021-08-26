<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property string $post_id 抓取的帖子ID
 * @property int $forum_id 需要发布的版块ID
 * @property int $circle_id 需要发布的圈子ID
 * @property int $is_active 是不是动态
 * @property int $status 0等待发布,1已经发布
 * @property int $need_comment 是否导入评论
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class DelayPostTask extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'delay_post_task';
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
    protected $casts = ['id' => 'int', 'forum_id' => 'integer', 'circle_id' => 'integer', 'is_active' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'status' => 'integer', 'need_comment' => 'integer'];
}