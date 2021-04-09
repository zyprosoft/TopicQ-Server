<?php
declare(strict_types=1);

return [
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