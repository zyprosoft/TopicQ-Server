<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $conversation_id 
 * @property int $owner_id 
 * @property int $to_user_id 
 * @property string $last_message 
 * @property string $last_message_time 
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
    protected $casts = ['conversation_id' => 'integer', 'owner_id' => 'integer', 'to_user_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}