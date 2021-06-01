<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class CreateSetupScoreAction extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Db::table('score_action')->insertOrIgnore([
            [
                'bind_action' => 'day_sign',
                'name' => '每日签到',
                'score' => 1,
                'day_max_times' => 1,
                'is_system' => 1,
            ],
            [
                'bind_action' => 'publish_post',
                'name' => '发帖',
                'score' => 3,
                'day_max_times' => 5,
                'is_system' => 1,
            ],
            [
                'bind_action' => 'post_sort_up',
                'name' => '帖子被置顶',
                'score' => 5,
                'day_max_times' => 0,
                'is_system' => 1,
            ],
            [
                'bind_action' => 'post_recommend',
                'name' => '帖子被推荐',
                'score' => 4,
                'day_max_times' => 0,
                'is_system' => 1,
            ],
            [
                'bind_action' => 'post_comment',
                'name' => '评论帖子',
                'score' => 2,
                'day_max_times' => 10,
                'is_system' => 1,
            ],
            [
                'bind_action' => 'comment_hot',
                'name' => '成为热评',
                'score' => 4,
                'day_max_times' => 0,
                'is_system' => 1,
            ],
            [
                'bind_action' => 'share',
                'name' => '分享',
                'score' => 8,
                'day_max_times' => 5,
                'is_system' => 1,
            ],
            [
                'bind_action' => 'post_favorite',
                'name' => '收藏帖子',
                'score' => 1,
                'day_max_times' => 1,
                'is_system' => 1,
            ],
            [
                'bind_action' => 'post_praise',
                'name' => '点赞帖子',
                'score' => 1,
                'day_max_times' => 1,
                'is_system' => 1,
            ],
            [
                'bind_action' => 'subscribe_forum',
                'name' => '订阅内容',
                'score' => 1,
                'day_max_times' => 1,
                'is_system' => 1,
            ],
        ]);
    }
}
