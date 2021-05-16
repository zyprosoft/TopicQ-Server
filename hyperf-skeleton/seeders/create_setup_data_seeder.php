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
            'name' => '管理员'
        ]);
        Db::table('role')->insertOrIgnore([
            'name' => '审核员'
        ]);
        Db::table('role')->insertOrIgnore([
            'name' => '巡查员'
        ]);

        Db::table('forum')->insertOrIgnore([
            'name' => '主板块',
            'icon' => 'none'
        ]);

        $nameList = [
            '推荐',
            '政务',
            '民生',
            '医疗',
            '教育',
            '美食',
            '娱乐',
            '阅读',
            '户外',
            '购物',
            '休闲',
            '汽车',
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
