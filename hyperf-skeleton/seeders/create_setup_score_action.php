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
                'day_once' => 1,
                'is_system' => 1,
            ],
            [
                'bind_action' => 'publish_post',
                'name' => '发帖',
                'score' => 1,
                'day_once' => 1,
                'is_system' => 1,
            ],
            [
                'bind_action' => 'day_sign',
                'name' => '每日签到',
                'score' => 1,
                'day_once' => 1,
                'is_system' => 1,
            ],
            [
                'bind_action' => 'day_sign',
                'name' => '每日签到',
                'score' => 1,
                'day_once' => 1,
                'is_system' => 1,
            ],
            [
                'bind_action' => 'day_sign',
                'name' => '每日签到',
                'score' => 1,
                'day_once' => 1,
                'is_system' => 1,
            ],
            [
                'bind_action' => 'day_sign',
                'name' => '每日签到',
                'score' => 1,
                'day_once' => 1,
                'is_system' => 1,
            ],
            [
                'bind_action' => 'day_sign',
                'name' => '每日签到',
                'score' => 1,
                'day_once' => 1,
                'is_system' => 1,
            ],
            [
                'bind_action' => 'day_sign',
                'name' => '每日签到',
                'score' => 1,
                'day_once' => 1,
                'is_system' => 1,
            ],
        ]);
    }
}
