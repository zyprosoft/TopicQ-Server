<?php
declare(strict_types=1);

return [
    'accessKey' => env('QINIU_ACCESS_KEY'),
    'secretKey' => env('QINIU_SECRET_KEY'),
    'loginTemplateId' => env('QINIU_LOGIN_SMS_TEMP_ID'),
    'appName' => env('QINIU_SMS_APP_NAME'),
];