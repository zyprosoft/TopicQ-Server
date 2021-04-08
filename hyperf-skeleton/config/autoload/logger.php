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
    'default' => [
        'handler' => [
            'class' => Monolog\Handler\RotatingFileHandler::class,
            'constructor' => [
                'filename' => BASE_PATH . '/runtime/logs/daily.log',
                'level' => Monolog\Logger::DEBUG,
            ],
        ],
        'formatter' => [
            'class' => Monolog\Formatter\LineFormatter::class,
            'constructor' => [
                'format' => "%datetime% || %channel% || %level_name% || %message% \n",
                'dateFormat' => 'Y-m-d H:i:s.u',
                'allowInlineLineBreaks' => true,
            ],
        ],
    ],
    'request' => [
        'handler' => [
            'class' => Monolog\Handler\RotatingFileHandler::class,
            'constructor' => [
                'filename' => BASE_PATH . '/runtime/logs/request.log',
                'level' => Monolog\Logger::DEBUG,
            ],
        ],
        'formatter' => [
            'class' => Monolog\Formatter\LineFormatter::class,
            'constructor' => [
                'format' => "%datetime% || %channel% || %level_name% || %message% \n",
                'dateFormat' => 'Y-m-d H:i:s.u',
                'allowInlineLineBreaks' => true,
            ],
        ],
        'processors' => [
            ['class' => Monolog\Processor\MemoryPeakUsageProcessor::class],
            ['class' => Monolog\Processor\MemoryUsageProcessor::class],
            ['class' => Monolog\Processor\WebProcessor::class],
        ],
    ],
    'system' => [
        'handler' => [
            'class' => Monolog\Handler\RotatingFileHandler::class,
            'constructor' => [
                'filename' => BASE_PATH . '/runtime/logs/system.log',
                'level' => Monolog\Logger::DEBUG,
            ],
        ],
        'formatter' => [
            'class' => Monolog\Formatter\LineFormatter::class,
            'constructor' => [
                'format' => "%datetime% || %channel% || %level_name% || %message% \n",
                'dateFormat' => 'Y-m-d H:i:s.u',
                'allowInlineLineBreaks' => true,
            ],
        ],
        'processors' => [
            ['class' => Monolog\Processor\MemoryPeakUsageProcessor::class],
            ['class' => Monolog\Processor\MemoryUsageProcessor::class],
        ],
    ],
    'task' => [
        'handler' => [
            'class' => Monolog\Handler\RotatingFileHandler::class,
            'constructor' => [
                'filename' => BASE_PATH . '/runtime/logs/task.log',
                'level' => Monolog\Logger::DEBUG,
            ],
        ],
        'formatter' => [
            'class' => Monolog\Formatter\LineFormatter::class,
            'constructor' => [
                'format' => "%datetime% || %channel% || %level_name% || %message% \n",
                'dateFormat' => 'Y-m-d H:i:s.u',
                'allowInlineLineBreaks' => true,
            ],
        ],
    ]
];
