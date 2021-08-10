<?php

/**
 * This file is part of ZYProSoft/Hyperf-Skeleton.
 *
 * @link     http://topicq.icodefuture.com
 * @document http://topicq.icodefuture.com
 * @contact  1003081775@qq.com
 * @Company  码动未来信息技术有限公司(CodeLeadsTheFuture)
 * @license  GPL
 */
declare (strict_types=1);
namespace App\Model;

use Hyperf\Scout\Searchable;
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
 * @property int $score 积分
 * @property int $group_id 用户的分组
 * @property string $qq_token qq登录Token
 * @property string $qq_openid qq登录openid
 * @property string $qq_token_expire qq登录Token过期时间
 * @property string $baidu_token 百度小程序Token
 * @property string $baidu_openid 百度openid
 * @property string $baidu_token_expire 百度token过期时间
 * @property string $byte_token 字节登录Token
 * @property string $byte_openid 字节openid
 * @property string $byte_token_expire 字节Token过期时间
 * @property-read \App\Model\UserGroup $group 
 * @property-read \App\Model\Role $role 
 * @property-read \App\Model\UserUpdate $update_info 
 */
class User extends Model implements Authenticatable
{
    use Searchable;
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
    protected $casts = ['user_id' => 'integer', 'role_id' => 'integer', 'status' => 'integer', 'sex' => 'integer', 'login_type' => 'integer', 'wx_gender' => 'integer', 'unread_comment_count' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'first_edit_done' => 'integer', 'wx_token_expire' => 'datetime', 'last_login' => 'datetime', 'token_expire' => 'datetime', 'user_update_id' => 'integer', 'avatar_user_id' => 'integer', 'score' => 'integer', 'group_id' => 'integer'];
    protected $hidden = ['mobile', 'password', 'wx_token', 'wx_openid', 'token', 'wx_token_expire',
        'token_expire',
        'avatar_user_id',
        'qq_token',
        'qq_openid',
        'qq_token_expire',
        'baidu_token',
        'baidu_openid',
        'baidu_token_expire',
        'byte_token',
        'byte_openid',
        'byte_token_expire',
    ];
    protected $with = ['role', 'group'];
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
        return $this->role_id > 0;
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
    public function toSearchableArray()
    {
        return ['nickname' => $this->nickname];
    }
    public function group()
    {
        return $this->hasOne(UserGroup::class, 'group_id', 'group_id');
    }
}