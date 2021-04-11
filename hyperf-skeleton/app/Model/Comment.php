<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $comment_id 
 * @property int $post_id 
 * @property int $parent_comment_id 
 * @property int $parent_comment_owner_id 
 * @property int $parent_comment_owner_is_read 
 * @property int $owner_id 
 * @property string $content 
 * @property string $link 
 * @property string $image_list 
 * @property int $praise_count 
 * @property int $reply_count 
 * @property int $audit_status 
 * @property string $audit_note 
 * @property int $is_hot 
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Comment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comment';

    protected $primaryKey = 'comment_id';

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
    protected $casts = ['comment_id' => 'integer', 'post_id' => 'integer', 'parent_comment_id' => 'integer', 'parent_comment_owner_id' => 'integer', 'parent_comment_owner_is_read' => 'integer', 'owner_id' => 'integer', 'praise_count' => 'integer', 'reply_count' => 'integer', 'audit_status' => 'integer', 'is_hot' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];


    public function parentComment()
    {
        return $this->hasOne(Comment::class,'comment_id','parent_comment_id');
    }

    public function post()
    {
        return $this->hasOne(Post::class,'post_id','post_id');
    }

    public function author()
    {
        return $this->hasOne(User::class,'user_id','owner_id');
    }
}