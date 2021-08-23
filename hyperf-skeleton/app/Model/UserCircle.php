<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $user_id 用户ID
 * @property int $circle_id 圈子ID
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $last_active_time 最后活跃时间
 * @property int $post_count 发表的动态数量
 * @property int $comment_count 发表的评论数量
 * @property int $topic_count 发表的话题数量
 * @property-read \App\Model\User $author 
 * @property-read \App\Model\Circle $circle 
 */
class UserCircle extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_circle';
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
    protected $casts = ['id' => 'int', 'user_id' => 'integer', 'circle_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'post_count' => 'integer', 'comment_count' => 'integer', 'topic_count' => 'integer'];
    protected $with = ['author'];
    public function author()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }
    public function circle()
    {
        return $this->hasOne(Circle::class, 'circle_id', 'circle_id');
    }
}