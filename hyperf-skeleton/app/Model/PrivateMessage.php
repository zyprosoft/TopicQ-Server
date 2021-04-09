<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $message_id 
 * @property int $from_id 
 * @property int $receive_id 
 * @property string $content 
 * @property string $image 
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
    protected $casts = ['message_id' => 'integer', 'from_id' => 'integer', 'receive_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}