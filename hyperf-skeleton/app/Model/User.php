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
 * @property string $username 用户名
 * @property string $password 密码
 * @property int $role_id 用户角色
 * @property string $mobile 手机
 * @property string $nickname 昵称
 * @property string $address 收货地址
 * @property string $avatar 头像
 * @property string $wx_openid 微信openid
 * @property string $wx_token 微信登陆token
 * @property int $status 设置用户的一些处理状态,0:正常
 * @property string $block_reason 拉黑原因
 * @property \Carbon\Carbon $last_login 上次登陆时间
 * @property string $location 位置
 * @property int $sex 0:男1:女
 * @property int $login_type 登陆类型;0:小程序1:web管理端
 * @property int $wx_gender 微信性别1:男
 * @property string $wx_province 微信省份
 * @property string $wx_city 微信城市
 * @property string $wx_country 微信国家
 * @property \Carbon\Carbon $wx_token_expire 微信token失效绝对时间
 * @property string $token 登陆的Token
 * @property \Carbon\Carbon $token_expire 登陆Token的过期时间
 * @property int $unread_comment_count 未读评论数量
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $area 县、区
 * @property string $country 乡镇
 * @property string $background 个人主页背景
 * @property int $first_edit_done 第一次编辑资料是否完成0:未完成1:已完成
 * @property int $user_update_id 用户更新资料的ID,临时资料ID,审核完成后置空
 * @property int $avatar_user_id 化身ID
 * @property-read \App\Model\Role $role 
 * @property-read \App\Model\UserUpdate $update_info 
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
    protected $casts = ['user_id' => 'integer', 'role_id' => 'integer', 'status' => 'integer', 'sex' => 'integer', 'login_type' => 'integer', 'wx_gender' => 'integer', 'unread_comment_count' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'first_edit_done' => 'integer', 'wx_token_expire' => 'datetime', 'last_login' => 'datetime', 'token_expire' => 'datetime', 'user_update_id' => 'integer', 'avatar_user_id' => 'integer'];
    protected $hidden = ['password', 'wx_token', 'wx_openid', 'token', 'wx_token_expire', 'token_expire'];
    protected $with = ['role'];
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
    public function role()
    {
        return $this->hasOne(Role::class, 'role_id', 'role_id');
    }
    /**
     * 用户提交更新资料的临时信息
     * @return \Hyperf\Database\Model\Relations\HasOne
     */
    public function update_info()
    {
        return $this->hasOne(UserUpdate::class, 'update_id', 'user_update_id');
    }
}