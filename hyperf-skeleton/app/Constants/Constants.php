<?php
/**
 * This file is part of ZYProSoft/Hyperf-Skeleton.
 *
 * @link     http://zyprosoft.lulinggushi.com
 * @document http://zyprosoft.lulinggushi.com
 * @contact  1003081775@qq.com
 * @Company  码动未来信息科技有限公司(ZYProSoft)
 * @license  GPL
 */
declare(strict_types=1);

namespace App\Constants;


class Constants
{
    const USER_ROLE_ADMIN = 1;

    /**
     * 微信SessionKey有效期30天，我们设定为25天，提前刷新
     */
    const WX_TOKEN_TTL = 60 * 60 * 24 * 25;
}