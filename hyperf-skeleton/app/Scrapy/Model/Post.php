<?php

declare(strict_types=1);

namespace App\Scrapy\Model;



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
    protected $casts = [];
}