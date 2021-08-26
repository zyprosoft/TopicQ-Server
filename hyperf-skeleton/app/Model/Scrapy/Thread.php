<?php

declare (strict_types=1);
namespace App\Model\Scrapy;

/**
 * @property int $id 
 * @property string $title 
 * @property string $author 
 * @property int $reply_num 
 * @property int $good 
 */
class Thread extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'thread';
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
    protected $casts = ['id' => 'int', 'reply_num' => 'integer', 'good' => 'integer'];

    protected $with = ['floor'];

    public function floor()
    {
        return $this->hasMany(Post::class,'thread_id','id')->where('floor',1);
    }
}