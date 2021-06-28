<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property string $app_name 名称
 * @property string $app_introduce 应用介绍
 * @property string $protocol_url 用户协议地址
 * @property string $about_url 关于地址
 * @property string $app_version 应用版本
 * @property string $contact_weixin 联系微信
 * @property int $custom_no_more 自定义没有更多
 * @property string $company 公司名
 * @property string $api_version 后端接口版本
 * @property string $theme_color 主题颜色
 * @property int $custom_theme 是否自定义主题颜色
 * @property int $theme_gradual 主题色是否渐变
 * @property int $subscribe_open 是否打开订阅0不打开1打开默认打开
 * @property int $private_message_open 私信功能是否打开0不打开1打开
 * @property int $message_on_attention 必须关注才能发消息0不需要1需要
 * @property int $self_mall_open 自营店铺，默认不打开,不打开的情况下我的订单也被隐藏起来
 * @property int $red_bag_post 悬赏帖是否打开
 * @property int $praise_cash_post 赞赏功能是否打开
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 * @property int $enable_user_video 是否开启普通用户可以发视频0不允许1允许
 * @property int $enable_user_create_topic 是否允许普通用户创建主题
 * @property int $enable_nav_forum 是否允许订阅版块提升到导航栏
 */
class AppSetting extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'app_setting';
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
    protected $casts = ['id' => 'int', 'custom_no_more' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'custom_theme' => 'integer', 'theme_gradual' => 'integer', 'subscribe_open' => 'integer', 'private_message_open' => 'integer', 'message_on_attention' => 'integer', 'self_mall_open' => 'integer', 'red_bag_post' => 'integer', 'praise_cash_post' => 'integer', 'enable_user_video' => 'integer', 'enable_user_create_topic' => 'integer', 'enable_nav_forum' => 'integer'];
}