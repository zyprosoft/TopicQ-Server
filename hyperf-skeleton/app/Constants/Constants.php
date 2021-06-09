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

    /**
     * 评论列表排序方式，最近发表
     */
    const COMMENT_SORT_TYPE_LATEST = 1;

    /**
     * 评论列表排序方式，最多回复
     */
    const COMMENT_SORT_TYPE_REPLY_COUNT = 2;

    /**
     * 评论列表排序方式，点赞数
     */
    const COMMENT_SORT_TYPE_PRAISE_COUNT = 3;

    /**
     * 只看博主
     */
    const COMMENT_SORT_TYPE_ONLY_POST_OWNER = 4;

    /**
     * 最早发表
     */
    const COMMENT_SORT_TYPE_POST_EARLY = 5;

    /**
     * 帖子列表排序方式，最近发表
     */
    const POST_SORT_TYPE_LATEST = 2;

    /**
     * 帖子列表排序方式，最多回复
     */
    const POST_SORT_TYPE_REPLY_COUNT = 1;

    /**
     * 订阅内容
     */
    const POST_SORT_TYPE_SUBSCRIBE = 4;

    /**
     * 关注内容
     */
    const POST_SORT_TYPE_ATTENTION = 5;

    /**
     * 帖子列表排序方式，最后回复
     */
    const POST_SORT_TYPE_LATEST_REPLY = 3;

    const STATUS_INVALIDATE = -1;

    const STATUS_WAIT = 0;

    const STATUS_DONE = 1;

    const STATUS_REVIEW = 2;

    const IMAGE_AUDIT_OWNER_POST = 0;

    const IMAGE_AUDIT_OWNER_COMMENT = 1;

    const IMAGE_AUDIT_OWNER_USER = 2;

    const MESSAGE_LEVEL_NORMAL = 0;
    const MESSAGE_LEVEL_WARN = 1;
    const MESSAGE_LEVEL_ERROR = 2;
    const MESSAGE_LEVEL_BLOCK = 3;

    const FORUM_TYPE_MAIN = 0;

    const FORUM_MAIN_FORUM_ID = 1;//主板块默认ID

    /**
     * 订单状态进行中
     */
    const ORDER_STATUS_PROCESSING = 0;

    /**
     * 订单确认收货
     */
    const ORDER_RECEIVE_STATUS_FINISH = 1;

    /**
     * 待支付
     */
    const ORDER_SUMMARY_NOT_PAY = 0;

    /**
     * 等待发货
     */
    const ORDER_SUMMARY_WAIT_DELIVER = 1;

    /**
     * 已经发货
     */
    const ORDER_SUMMARY_DELIVERED = 2;

    /**
     * 发货完成
     */
    const ORDER_SUMMARY_FINISH = 3;

    /**
     * 自营店铺类型
     */
    const MALL_TYPE_SELF = 1;

    const MALL_TYPE_PDD = 0;

    const BUY_FORUM_ID = 9;

    const STATUS_OK = 1;

    const STATUS_NOT = 0;

    const GOODS_ID_INVALIDATE = 0;

    const SUBSCRIBE_GOODS_CATEGORY_ID = 1;//虚拟产品默认分类1

    /**
     * 分类中由系统创建的
     */
    const CATEGORY_SHOP_ID_SYSTEM_USE = -1;

    const VOUCHER_TIME_UNIT_MINUTE = 'p';
    const VOUCHER_TIME_UNIT_HOUR = 'h';
    const VOUCHER_TIME_UNIT_DAY = 'd';
    const VOUCHER_TIME_UNIT_MONTH = 'm';
    const VOUCHER_TIME_UNIT_YEAR = 'y';

    const VOUCHER_USE_HISTORY_STATUS_NORMAL = 0;
    const VOUCHER_USE_HISTORY_STATUS_ROLLBACK = -1;

    const VOUCHER_STATUS_EXPIRED = 2;
    const VOUCHER_STATUS_INVALIDATE = -1;
    const VOUCHER_STATUS_USED = 1;
    const VOUCHER_STATUS_WAIT = 0;

    const VIDEO_POST_LIST_TYPE_ADMIN = 1;
    const VIDEO_POST_LIST_TYPE_CUSTOMER = 2;
    const VIDEO_POST_LIST_TYPE_BOTH = 3;

    const TOPIC_POST_LIST_SORT_BY_HOT = 0;
    const TOPIC_POST_LIST_SORT_BY_LATEST = 1;

    //积分行为枚举
    const SCORE_ACTION_DAY_SIGN = 'day_sign';
    const SCORE_ACTION_PUBLISH_POST = 'publish_post';
    const SCORE_ACTION_POST_SORT_UP = 'post_sort_up';
    const SCORE_ACTION_POST_RECOMMEND = 'post_recommend';
    const SCORE_ACTION_POST_COMMENT = 'post_comment';
    const SCORE_ACTION_COMMENT_HOT = 'comment_hot';
    const SCORE_ACTION_SHARE = 'share';
    const SCORE_ACTION_POST_FAVORITE = 'post_favorite';
    const SCORE_ACTION_POST_PRAISE = 'post_praise';
    const SCORE_ACTION_SUBSCRIBE_FORUM = 'subscribe_forum';

    const ACTIVITY_TYPE_INDEX = 0;
    const ACTIVITY_TYPE_FORUM = 1;

    const FORUM_POST_SORT_HOT = 0;
    const FORUM_POST_SORT_LATEST = 1;

    const RICH_CONTENT_TYPE_TEXT = 'text';
    const RICH_CONTENT_TYPE_BIG_IMAGE = 'big_image';
    const RICH_CONTENT_TYPE_SMALL_IMAGE = 'small_image';
    const RICH_CONTENT_TYPE_VIDEO = 'video';

    //普通用户每天最多上传次数
    const USER_MAX_UPLOAD_TIMES_PER_DAY = 100;
}