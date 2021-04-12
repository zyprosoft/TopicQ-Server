<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $conversation_id 
 * @property int $owner_id 会话所有者
 * @property int $to_user_id 会话对话人
 * @property string $last_message 最后一条消息会话内容
 * @property string $last_message_time 最后一条消息时间
 * @property int $unread_count 未读消息数
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Conversation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'conversation';
    protected $primaryKey = 'conversation_id';
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
    protected $casts = ['conversation_id' => 'integer', 'owner_id' => 'integer', 'to_user_id' => 'integer', 'unread_count' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    protected $with = [
        'owner',
        'receiver'
    ];

    public function owner()
    {
        return $this->hasOne(User::class,'user_id','owner_id');
    }

    public function receiver()
    {
        return $this->hasOne(User::class,'user_id','to_user_id');
    }
}