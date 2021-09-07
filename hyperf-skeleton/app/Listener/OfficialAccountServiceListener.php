<?php
/**
 * This file is part of ZYProSoft/Hyperf-Skeleton.
 *
 * @link     http://zyprosoft.lulinggushi.com
 * @document http://zyprosoft.lulinggushi.com
 * @contact  1003081775@qq.com
 * @Company  码动未来信息技术有限公司(ZYProSoft)
 * @license  GPL
 */
declare (strict_types=1);

namespace App\Listener;

use App\Service\OfficialAccountService;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Metric\Listener\OnWorkerStart;
use Hyperf\Utils\ApplicationContext;

class OfficialAccountServiceListener implements ListenerInterface
{
    public function listen(): array
    {
        // 返回一个该监听器要监听的事件数组，可以同时监听多个事件
        return [
            OnWorkerStart::class,
        ];
    }

    /**
     * @param OnWorkerStart $event
     */
    public function process(object $event)
    {
        ApplicationContext::getContainer()->get(OfficialAccountService::class);
    }
}