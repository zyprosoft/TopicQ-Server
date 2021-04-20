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
declare(strict_types=1);
namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class ErrorCode extends AbstractConstants
{
    /**
     * @Message("Server Error！")
     */
    const SERVER_ERROR = 500;

    /**
     * @Message("刷新Token所使用的Token非法")
     */
    const USER_REFRESH_TOKEN_INVALIDATE = 30017;

    /**
     * @Message("用户密码错误")
     */
    const USER_ERROR_PASSWORD_WRONG = 20000;

    /**
     * @Message("非法操作!")
     */
    const NOT_OWN_BY_CURRENT_USER = 30001;

    /**
     * @Message("不要重复操作!")
     */
    const DO_NOT_REPEAT_ACTION = 30002;

    /**
     * @Message("帖子不存在!")
     */
    const POST_NOT_EXIST = 30003;

    /**
     * @Message("警告，请不要上传敏感图片!")
     */
    const IMAGE_AUDIT_INVALIDATE = 30004;
}
