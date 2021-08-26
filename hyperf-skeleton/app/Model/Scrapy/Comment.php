<?php

declare (strict_types=1);
namespace App\Model\Scrapy;

/**
 * @property int $id 
 * @property string $author 
 * @property string $content 
 * @property string $time 
 * @property int $post_id 
 */
class Comment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comment';
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
    protected $casts = ['id' => 'int', 'post_id' => 'integer'];
}