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
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
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
    protected $casts = ['id' => 'int', 'custom_no_more' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}