<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class CreateCircleCategorySetupDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Db::table('circle_category')->insertOrIgnore([
            [
                'name' => '班级',
            ],
            [
                'name' => '校友',
            ],
            [
                'name' => '电影',
            ],
            [
                'name' => '音乐',
            ],
            [
                'name' => '生活',
            ],
            [
                'name' => '兴趣',
            ],
            [
                'name' => '运动',
            ],
            [
                'name' => '旅行',
            ],
            [
                'name' => '知识',
            ],
            [
                'name' => '阅读',
            ],
            [
                'name' => '动漫',
            ],
            [
                'name' => '情感',
            ],
            [
                'name' => '考研',
            ],
            [
                'name' => '娱乐',
            ],
            [
                'name' => '宠物',
            ],
            [
                'name' => '美食',
            ],
            [
                'name' => '摄影',
            ],
            [
                'name' => '时尚',
            ],
            [
                'name' => '游戏',
            ],
            [
                'name' => '打卡',
            ],
            [
                'name' => '人文',
            ],
            [
                'name' => '艺术',
            ],
            [
                'name' => '粉丝',
            ],
            [
                'name' => '交友',
            ],
        ]);
    }
}
