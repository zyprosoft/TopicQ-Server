<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class CreateSetupDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('role')->insertOrIgnore([
            'name' => '系统维护'
        ]);
        Db::table('role')->insertOrIgnore([
            'name' => '管理员'
        ]);
        Db::table('role')->insertOrIgnore([
            'name' => '编辑'
        ]);

        Db::table('forum')->insertOrIgnore([
            'name' => '主板块',
            'icon' => 'none'
        ]);

        $nameList = [
            '推荐',
            '美食',
            '娱乐',
            '阅读',
            '户外',
            '工具',
        ];
        foreach ($nameList as $name)
        {
            Db::table('mini_program_category')->insertOrIgnore([
                'name'=>$name
            ]);
            Db::table('official_account_category')->insertOrIgnore([
                'name'=>$name
            ]);
        }
    }
}
