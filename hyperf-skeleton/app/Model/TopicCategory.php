<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $category_id 
 * @property string $name 话题分类名称
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 */
class TopicCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'topic_category';
    protected $primaryKey = 'category_id';
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
    protected $casts = ['category_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}