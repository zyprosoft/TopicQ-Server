<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $user_id 用户ID
 * @property int $account_id 公众号记录ID
 * @property int $count 使用次数
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 */
class UserOfficialAccountUse extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_official_account_use';
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
    protected $casts = ['id' => 'int', 'user_id' => 'integer', 'account_id' => 'integer', 'count' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}