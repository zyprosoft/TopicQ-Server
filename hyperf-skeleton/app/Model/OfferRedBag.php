<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $offer_id 
 * @property int $red_bag_id 红包ID
 * @property int $amount 金额，单位分
 * @property int $owner_id 归属人ID,0为未分给用户
 * @property string $expire_time 过期时间,没有就是没过期时间
 * @property int $status 状态0正常-1作废
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class OfferRedBag extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'offer_red_bag';

    protected $primaryKey = 'offer_id';

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
    protected $casts = ['offer_id' => 'integer', 'red_bag_id' => 'integer', 'amount' => 'integer', 'owner_id' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}