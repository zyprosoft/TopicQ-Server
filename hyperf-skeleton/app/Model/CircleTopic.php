<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $topic_id 
 * @property string $title 话题名字
 * @property int $owner_id 创建者
 * @property int $circle_id 圈子ID
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 * @property int $post_count 帖子数
 * @property int $member_count 话题参与人数
 * @property string $last_active_time 
 * @property int $today_post_count 
 * @property-read \App\Model\User $author 
 * @property-read \App\Model\Circle $circle 
 */
class CircleTopic extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'circle_topic';
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
    protected $casts = ['topic_id' => 'integer', 'owner_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'circle_id' => 'integer', 'post_count' => 'integer', 'member_count' => 'integer', 'today_post_count' => 'integer'];
    public function circle()
    {
        return $this->hasOne(Circle::class, 'circle_id', 'circle_id');
    }
    public function author()
    {
        return $this->hasOne(User::class, 'user_id', 'owner_id');
    }
}