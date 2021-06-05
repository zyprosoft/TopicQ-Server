<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property-read \App\Model\User $author 
 * @property-read \App\Model\Post $post 
 */
class UserPraisePost extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_praise_post';
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
    protected $casts = ['id' => 'int', 'user_id' => 'integer', 'post_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
    public function author()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }
    public function post()
    {
        return $this->hasOne(Post::class, 'post_id', 'post_id')->select(['title', 'post_id']);
    }
}