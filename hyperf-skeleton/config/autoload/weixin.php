<?php
declare(strict_types=1);

return [
    'payment' => [
        // 必要配置
        'app_id' => env('WX_MINI_APPID'),
        'mch_id' => env('WX_PAY_MCH_ID'),
        'key' => env('WX_PAY_SECRET'),   // API 密钥

        // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
        'cert_path' => 'path/to/your/cert.pem', // XXX: 绝对路径！！！！
        'key_path' => 'path/to/your/key',      // XXX: 绝对路径！！！！

        'notify_url' => env('WX_PAY_NOTIFY_URL'),     // 你也可以在下单时单独设置来想覆盖它
        'bill_create_ip' => env('WX_PAY_BILL_IP'),

        'log' => [
            'level' => 'debug',
            'file' => BASE_PATH . '/runtime/logs/wxpay.log',
        ],
    ],
    'miniProgram' => [

        'env' => env('WX_MINI_ENV'), //developer开发;trial体验;formal正式
        'app_id' => env('WX_MINI_APPID'),
        'secret' => env('WX_MINI_SECRET'),

        // 下面为可选项
        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',

        'log' => [
            'level' => 'debug',
            'file' => BASE_PATH . '/runtime/logs/wechat_mini.log',
        ],
    ]
];