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

    /**
     * @Message("外显小程序最多3个!")
     */
    const OUTSIDE_MINI_PROGRAM_FULL = 30005;

    /**
     * @Message("调用拼多多错误!")
     */
    const CALL_PDD_ERROR = 30006;

    /**
     * @Message("用户已被平台拉黑!")
     */
    const USER_BLOCK_BY_PLATFORM = 30007;

    /**
     * @Message("店铺不归属当前用户!")
     */
    const SHOP_NOT_BELONG_CURRENT_USER = 30008;

    /**
     * @Message("物品不归属当前用户!")
     */
    const STAFF_NOT_BELONG_CURRENT_USER = 30009;

    /**
     * @Message("请求微信支付失败!")
     */
    const REQUEST_WX_PAY_FAIL = 30010;

    /**
     * @Message("订单已经是支付状态,请勿重复支付!")
     */
    const ORDER_DID_FINISH_PAY = 30011;

    /**
     * @Message("店铺已停止发布")
     */
    const SHOP_PAUSED_PUBLISH = 30012;

    /**
     * @Message("下单商品超过当前库存,请修改数量!")
     */
    const ORDER_GOODS_COUNT_OVER_STOCK = 30013;

    /**
     * @Message("解锁订阅密码错误!")
     */
    const FORUM_UNLOCK_PASSWORD_ERROR = 30014;

    /**
     * @Message("本批次授权已经用完!")
     */
    const FORUM_UNLOCK_POLICY_COUNT_ERROR = 30015;

    /**
     * @Message("本授权码已经使用!")
     */
    const FORUM_UNLOCK_STATUS_DONE = 30016;

    /**
     * @Message("本批次授权已经失效!")
     */
    const FORUM_UNLOCK_STATUS_INVALIDATE = 30017;

    /**
     * @Message("本授权与提交订阅板块不一致!")
     */
    const FORUM_UNLOCK_NOT_EQUAL = 30018;

    /**
     * @Message("付费或授权板块未获得权限")
     */
    const FORUM_NOT_PAY_OR_AUTH = 30019;

    /**
     * @Message("包含已经订阅过的商品!")
     */
    const BUY_FORUM_NOT_NEED = 30020;

    /**
     * @Message("本板块帖子需要付费才可查看!")
     */
    const FORUM_POST_NEED_PAY = 30021;

    /**
     * @Message("本板块帖子需要授权才可查看!")
     */
    const FORUM_POST_NEED_AUTH = 30022;
}
