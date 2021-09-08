<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property string $open_id 公众号openID
 * @property string $union_id unionID
 * @property int $is_subscribe 是否关注公众号
 * @property string $attention_time 关注时间
 * @property string $attention_scene 关注时间
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class OfficialAccountUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'official_account_user';
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
    protected $casts = ['id' => 'int', 'is_subscribe' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}