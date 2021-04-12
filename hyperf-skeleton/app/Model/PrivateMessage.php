<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $message_id 
 * @property int $from_id 发出者
 * @property int $receive_id 接受者
 * @property string $content 消息内容
 * @property string $image 图片内容
 * @property int $read_status 0:未读1:已读
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class PrivateMessage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'private_message';
    protected $primaryKey = 'message_id';
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
    protected $casts = ['message_id' => 'integer', 'from_id' => 'integer', 'receive_id' => 'integer', 'read_status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    protected $with = [
        'sender',
        'receiver'
    ];

    public function sender()
    {
        return $this->hasOne(User::class,'user_id','from_id');
    }

    public function receiver()
    {
        return $this->hasOne(User::class,'user_id','receive_id');
    }
}