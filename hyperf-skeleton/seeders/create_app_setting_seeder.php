<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class CreateAppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Db::table('app_setting')->insertOrIgnore([
            'app_name' => '翠湖畔',
            'custom_no_more' => 1,
            'company' => '码动未来信息科技',
            'contact_weixin' => '微信(13177627765)',
        ]);
    }
}
