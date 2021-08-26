<?php

declare (strict_types=1);
namespace App\Model\Scrapy;

/**
 * @property int $id 
 * @property int $floor 
 * @property string $author 
 * @property string $content 
 * @property string $time 
 * @property int $comment_num 
 * @property int $thread_id 
 */
class Post extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post';
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'scrapy';
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
    protected $casts = ['id' => 'int', 'floor' => 'integer', 'comment_num' => 'integer', 'thread_id' => 'integer'];

    protected $with = ['reply_list'];

    public function reply_list()
    {
        return $this->hasMany(Comment::class,'id','post_id');
    }
}