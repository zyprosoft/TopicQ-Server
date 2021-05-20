<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $user_id 用户ID
 * @property int $other_user_id 被关注用户ID
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class UserAttentionOther extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_attention_other';
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
    protected $casts = ['id' => 'int', 'user_id' => 'integer', 'other_user_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function owner()
    {
        return $this->hasOne(User::class,'user_id','user_id');
    }

    public function other()
    {
        return $this->hasOne(User::class,'user_id','other_user_id');
    }
}