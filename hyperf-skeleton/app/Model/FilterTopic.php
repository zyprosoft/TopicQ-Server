<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property string $ref_id 引用ID
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class FilterTopic extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'filter_topic';
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
    protected $casts = ['id' => 'int', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}