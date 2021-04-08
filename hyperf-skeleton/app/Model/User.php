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
 * @property int $user_id 自增ID
 * @property int $role_id 角色ID
 * @property string $username 账号
 * @property string $nickname 昵称
 * @property string $password 密码
 * @property string $mobile 手机号
 * @property string $avatar 头像
 * @property int $approved 注册是否审核通过
 * @property string $reason 驳回原因
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
    protected $casts = ['user_id' => 'integer', 'role_id' => 'integer', 'approved' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    protected $hidden = ['password'];

    public function getId()
    {
        return $this->user_id;
    }

    public static function retrieveById($key) : ?Authenticatable
    {
        return User::find(key);
    }

    public function isAdmin()
    {
        return $this->role_id == Constants::USER_ROLE_ADMIN;
    }
}