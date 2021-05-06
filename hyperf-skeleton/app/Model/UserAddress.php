<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $owner_id 用户ID
 * @property string $nickname 收货人
 * @property int $postal_code 邮政编码
 * @property string $province 省份
 * @property string $city 城市
 * @property string $country 县区
 * @property string $detail_info 详细地址
 * @property string $national_code 国家编号
 * @property string $phone_number 联系电话
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 */
class UserAddress extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_address';
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
    protected $casts = ['id' => 'int', 'owner_id' => 'integer', 'postal_code' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}