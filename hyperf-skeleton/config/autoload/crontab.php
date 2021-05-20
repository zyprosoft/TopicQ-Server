<?php
use Hyperf\Crontab\Crontab;
use ZYProSoft\Task\ClearExpireCaptchaTask;
use ZYProSoft\Task\ClearLogFileTask;
use App\Task\PostRecommendCalculateTask;
use App\Task\VoucherExpireTask;
use App\Task\UpdateTopicTask;

return [
    // 是否开启定时任务
    'enable' => true,
    'crontab' => [
        (new Crontab())->setName('clearCaptcha')
            ->setRule('*/10 * * * *')
            ->setCallback([ClearExpireCaptchaTask::class, 'execute'])
            ->setMemo('定时清除过期的验证码'),
        (new Crontab())->setName('updateTopic')
            ->setRule('*/10 * * * *')
            ->setCallback([UpdateTopicTask::class, 'execute'])
            ->setMemo('定时刷新主题'),
        (new Crontab())->setName('clearLog')
            ->setRule('5 0 * * *')
            ->setCallback([ClearLogFileTask::class, 'execute'])
            ->setMemo('定时清除日志'),
        (new Crontab())->setName('calculateRecommendWeight')
            ->setRule('*/10 * * * *')
            ->setCallback([PostRecommendCalculateTask::class, 'execute'])
            ->setMemo('定时统计帖子推荐权重'),
        (new Crontab())->setName('calculateRecommendWeight')
            ->setRule('10 0 * * *')
            ->setCallback([VoucherExpireTask::class, 'execute'])
            ->setMemo('每天定时过期代金券'),
    ]
];