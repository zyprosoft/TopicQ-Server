<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $category_id 
 * @property string $name 名字
 * @property int $sort_index 排序索引
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class CircleCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'circle_category';
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
    protected $casts = ['category_id' => 'integer', 'sort_index' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public function circles()
    {
        return $this->hasMany(Circle::class,'category_id','category_id');
    }
}