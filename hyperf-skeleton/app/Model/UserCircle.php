<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $user_id 用户ID
 * @property int $circle_id 圈子ID
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
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
    protected $casts = ['id' => 'int', 'user_id' => 'integer', 'circle_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}