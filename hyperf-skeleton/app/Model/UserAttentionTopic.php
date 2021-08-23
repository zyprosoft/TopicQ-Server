<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $user_id 用户ID
 * @property int $topic_id 话题ID
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \App\Model\Topic $topic 
 */
class UserAttentionTopic extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_attention_topic';
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
    protected $casts = ['id' => 'int', 'user_id' => 'integer', 'topic_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
    protected $with = ['topic'];
    public function topic()
    {
        return $this->hasOne(Topic::class, 'topic_id', 'topic_id');
    }
}