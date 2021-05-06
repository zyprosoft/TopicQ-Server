<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $category_id 
 * @property string $name 分类名称
 * @property int $create_user 创建者
 * @property string $note 备注
 * @property string $image 图片
 * @property int $shop_id 店铺ID，系统分类此店铺ID为-1
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class GoodsCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'goods_category';

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
    protected $casts = ['category_id' => 'integer', 'create_user' => 'integer', 'shop_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}