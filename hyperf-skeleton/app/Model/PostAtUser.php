<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $post_id 帖子ID
 * @property int $user_id 用户ID
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \App\Model\User $author 
 */
class PostAtUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_at_user';
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
    protected $casts = ['id' => 'int', 'post_id' => 'integer', 'user_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
    protected $with = ['author'];
    public function author()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id')->select(['nickname', 'user_id']);
    }
}