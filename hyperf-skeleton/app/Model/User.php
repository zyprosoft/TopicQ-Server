<?php

/**
 * This file is part of ZYProSoft/Hyperf-Skeleton.
 *
 * @link     http://zyprosoft.lulinggushi.com
 * @document http://zyprosoft.lulinggushi.com
 * @contact  1003081775@qq.com
 * @Company  码动未来信息技术有限公司(ZYProSoft)
 * @license  GPL
 */
declare (strict_types=1);
namespace App\Model;

use Hyperf\Database\Model\Events\Creating;
use Qbhy\HyperfAuth\Authenticatable;
use App\Constants\Constants;
/**
 * @property int $user_id 
 * @property string $username 
 * @property string $password 
 * @property int $role_id 
 * @property string $mobile 
 * @property string $nickname 
 * @property string $address 
 * @property string $avatar 
 * @property string $wx_openid 
 * @property string $wx_token 
 * @property int $status 
 * @property string $block_reason 
 * @property string $last_login 
 * @property string $location 
 * @property int $sex 
 * @property int $login_type 
 * @property int $wx_gender 
 * @property string $wx_province 
 * @property string $wx_city 
 * @property string $wx_country 
 * @property string $wx_token_expire 
 * @property string $token 
 * @property string $token_expire 
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class User extends Model implements Authenticatable
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

    protected $primaryKey = 'user_id';

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
    protected $casts = ['user_id' => 'integer', 'role_id' => 'integer', 'status' => 'integer', 'sex' => 'integer', 'login_type' => 'integer', 'wx_gender' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
    protected $hidden = ['password'];
    public function getId()
    {
        return $this->user_id;
    }
    public static function retrieveById($key) : ?Authenticatable
    {
        return User::find($key);
    }
    public function isAdmin()
    {
        return $this->role_id == Constants::USER_ROLE_ADMIN;
    }
}