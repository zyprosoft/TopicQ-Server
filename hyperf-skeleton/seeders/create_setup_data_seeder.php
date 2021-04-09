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
        Db::table('user')->insertOrIgnore([
            'role_id' => 1,
            'username' => 'admin',
            'password' => password_hash('admin123',PASSWORD_DEFAULT),
            'nickname' => '流水青葱岁月',
            'wx_openid' => 'admin',
        ]);
        Db::table('user')->insertOrIgnore([
            'role_id' => 0,
            'username' => 'guest',
            'password' => password_hash('guest123',PASSWORD_DEFAULT),
            'nickname' => '测试账号',
            'wx_openid' => 'guest',
        ]);
    }
}
