<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $circle_id 圈子ID
 * @property int $user_id 用户ID
 * @property int $post_count 动态数量
 * @property int $comment_count 评论数量
 * @property int $praise_count 动态被点赞数量
 * @property int $favorite_count 动态被收藏数量
 * @property int $recommend 推荐权重
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class CircleExpert extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'circle_expert';
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
    protected $casts = ['id' => 'int', 'circle_id' => 'integer', 'user_id' => 'integer', 'post_count' => 'integer', 'comment_count' => 'integer', 'praise_count' => 'integer', 'favorite_count' => 'integer', 'recommend' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}