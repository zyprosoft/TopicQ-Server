<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    'http' => [
        Hyperf\Metric\Middleware\MetricMiddleware::class,
        ZYProSoft\Middleware\ValidatePostSizeMiddleware::class,
        Hyperf\Session\Middleware\SessionMiddleware::class,
        ZYProSoft\Middleware\CrossOriginMiddleware::class,
        ZYProSoft\Middleware\RequestLimitMiddleware::class,
        ZYProSoft\Middleware\RequestAuthMiddleware::class,
        Hyperf\Validation\Middleware\ValidationMiddleware::class,
    ],
];
