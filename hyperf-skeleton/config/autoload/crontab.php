<?php
use Hyperf\Crontab\Crontab;
use ZYProSoft\Task\ClearExpireCaptchaTask;
use ZYProSoft\Task\ClearLogFileTask;
use App\Task\PostRecommendCalculateTask;

return [
    // 是否开启定时任务
    'enable' => true,
    'crontab' => [
        (new Crontab())->setName('clearCaptcha')
            ->setRule('*/10 * * * *')
            ->setCallback([ClearExpireCaptchaTask::class, 'execute'])
            ->setMemo('定时清除过期的验证码'),
        (new Crontab())->setName('clearLog')
            ->setRule('5 0 * * *')
            ->setCallback([ClearLogFileTask::class, 'execute'])
            ->setMemo('定时清除过期的验证码'),
        (new Crontab())->setName('calculateRecommendWeight')
            ->setRule('*/10 * * * *')
            ->setCallback([PostRecommendCalculateTask::class, 'execute'])
            ->setMemo('定时统计帖子推荐权重'),
    ]
];