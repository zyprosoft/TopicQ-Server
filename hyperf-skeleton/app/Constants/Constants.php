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
    const USER_ROLE_NORMAL = 1;

    const USER_ROLE_ADMIN = 2;

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
}