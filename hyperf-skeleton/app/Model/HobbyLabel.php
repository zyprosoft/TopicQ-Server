<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $hobby_id 
 * @property int $category_id 所属分类
 * @property string $title 内容
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class HobbyLabel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hobby_label';
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
    protected $casts = ['hobby_id' => 'integer', 'category_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}