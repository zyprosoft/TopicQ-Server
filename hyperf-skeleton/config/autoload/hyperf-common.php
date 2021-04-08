<?php
/**
 * This file is part of ZYProSoft/Hyperf-Common.
 *
 * @link     http://zyprosoft.lulinggushi.com
 * @document http://zyprosoft.lulinggushi.com
 * @contact  1003081775@qq.com
 * @Company  泽湾普罗信息技术有限公司(ZYProSoft)
 * @license  GPL
 */
declare(strict_types=1);
use Hyperf\Utils\Str;

//设置加密密钥对
$zgwSecretList = env('ZGW_SECRET_LIST');//密钥对列表 test&abcdefg;test1&abcdefg
$appSecretList = [];
if (isset($zgwSecretList)) {
    $zgwSecretList = explode(';', $zgwSecretList);
    array_map(function (string $item) use (&$appSecretList) {
        if (Str::contains($item, '&')) {
            $itemArray = explode('&', $item);
            if (count($itemArray) == 2) {
                $appSecretList[$itemArray[0]] = $itemArray[1];
            }
        }
    }, $zgwSecretList);
}

//设置跨域白名单
$corsDomainList = env('CORS_ORIGIN_LIST');//跨域白名单http://localhost:8081
$appCorsDomainList = [];
if(isset($corsDomainList)) {
    $appCorsDomainList = explode(';', $corsDomainList);
}

//设置限频接口白名单
$rateLimitWhiteList = env('RATE_LIMIT_WHITE_LIST');//频率限制白名单接口 eg. /weixin;/admin*
$appRateLimitWhiteList = [];
if(isset($rateLimitWhiteList)) {
    $appRateLimitWhiteList = explode(';', $rateLimitWhiteList);
}

return [
    'zgw' => [
        'force_auth' => env('ZGW_FORCE_AUTH', false),//强制校验签名,开启后ZGW协议必须带签名参数访问
        'sign_ttl' => env('ZGW_SIGN_TTL', 10),//签名有效时间
        'config_list' => $appSecretList,//密钥对列表 eg. test&abcdefg;test1&abcdefg
    ],
    'captcha' => [
        'strict' => env('CAPTCHA_STRICT', false),//验证码是否严格模式，区分大小写输入
        'ttl' => env('CAPTCHA_TTL', 600), //验证码有效时间
        'prefix' => env('CAPTCHA_PREFIX', 'cpt'), //缓存前缀
        'dirname' => env('CAPTCHA_DIRNAME', '/captcha') //存储目录
    ],
    'cors' => [
        'enable_cross_origin' => env('CORS_ENABLE_CORS_ORIGIN', true), //是否开启跨域限制
        'allow_cross_origins' => $appCorsDomainList, //跨域白名单 eg. http://localhost:8081
    ],
    'rate_limit' => [
        'enable' => env('RATE_LIMIT_ENABLE', false),//是否开启请求频率限制
        'access_rate_limit' => env('RATE_LIMIT_COUNT', 10), //频率限制次数
        'access_rate_ttl' => env('RATE_LIMIT_TTL', 20), //频率限制秒，两者组合为每20秒内最多允许10次请求单一接口
        'white_list' => $appRateLimitWhiteList, //频率限制白名单接口 eg. /weixin;/admin*
    ],
    'clear_log' => [
        'days' => env('CLEAR_LOG_KEEP_DAYS', 3), // 只保留三天的日志，三天以前的自动清除,设置成-1表示不执行清除任务
    ],
    'mail' => [
        'smtp' => [
            'host' => env('MAIL_SMTP_HOST', 'smtp.qq.com'), //smtp服务器地址
            'auth' => env('MAIL_SMTP_AUTH', true), //smtp是否需要鉴权
            'username' => env('MAIL_SMTP_USER_NAME', ''),//qq邮箱账号,eg. 1003081775@qq.com
            'password' => env('MAIL_SMTP_PASSWORD', ''),//qq邮箱申请的授权密码
            'port' => env('MAIL_SMTP_PORT','465'), //qq邮箱经测试是465端口+ssl协议有效果
            'secure' => env('MAIL_SMTP_SECURE','ssl') //smtp通信协议ssl或者tls
        ]
    ],
    'upload' => [
        'system_type' => env('UPLOAD_STORE_TYPE', 'local'), //使用上传的类型，对应下面的配置的key，如本地使用local,七牛云使用qiniu
        'max_file_size' => env('UPLOAD_MAX_FILE_SIZE', 1024*1024*5),//单位字节，默认5M
        'file_type_limit' => env('UPLOAD_TYPE_LIMIT', "*"),//用英文分号进行分割的image/jpeg;image/jpg;image/*全匹配图片,*为全匹配
        'local' => [
            'common_dir' => env('LOCAL_COMMON_DIR', '/upload/common'),//通用的文件上传目录
            'image_dir' => env('LOCAL_IMAGE_DIR', '/upload/image'),//本地图片路径，位于server.settings.document_root配置目录之下
            'url_prefix' => env('LOCAL_IMAGE_URL_PREFIX',''),//当上传到本地的时候，拼接的图片路径
        ],
        'qiniu' => [
            'token_ttl' => env('QINIU_TOKEN_TTL', 3600),//获取qiniu访问token的过期时间
        ],
    ]
];