<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Db::table('user')->insertOrIgnore([
            [
                'username' => 'admin',
                'role_id' => 1,
                'password' => password_hash('admin123',PASSWORD_DEFAULT)
            ]
        ]);
    }
}
