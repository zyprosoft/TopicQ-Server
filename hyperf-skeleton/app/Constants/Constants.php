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
     * 帖子列表排序方式，最近发表
     */
    const POST_SORT_TYPE_LATEST = 1;

    /**
     * 帖子列表排序方式，最多回复
     */
    const POST_SORT_TYPE_REPLY_COUNT = 2;

    /**
     * 帖子列表排序方式，最后回复
     */
    const POST_SORT_TYPE_LATEST_REPLY = 3;
}