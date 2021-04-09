<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $post_id 
 * @property string $title 
 * @property string $summary 
 * @property string $content 
 * @property string $image_list 
 * @property int $owner_id 
 * @property string $link 
 * @property int $vote_id 
 * @property int $read_count 
 * @property int $favorite_count 
 * @property int $forward_count 
 * @property int $comment_count 
 * @property int $audit_status 
 * @property string $audit_note 
 * @property int $is_hot 
 * @property string $last_comment_time 
 * @property int $sort_index 
 * @property int $is_recommend 
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Post extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post';

    protected $primaryKey = 'post_id';

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
    protected $casts = ['post_id' => 'integer', 'owner_id' => 'integer', 'vote_id' => 'integer', 'read_count' => 'integer', 'favorite_count' => 'integer', 'forward_count' => 'integer', 'comment_count' => 'integer', 'audit_status' => 'integer', 'is_hot' => 'integer', 'sort_index' => 'integer', 'is_recommend' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];


    public function author()
    {
        return $this->hasOne(User::class,'user_id','owner_id');
    }

    public function vote()
    {
        return $this->hasOne(Vote::class,'vote_id','vote_id');
    }
}