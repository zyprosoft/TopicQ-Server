<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class CreateSignStatusInitData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Db::table('sign_status')->insertOrIgnore([
            [
                'name' => '单身中',
            ],
            [
                'name' => '暗恋中',
            ],
            [
                'name' => '想恋爱',
            ],
            [
                'name' => '甜恋中',
            ],
            [
                'name' => '养火花',
            ],
            [
                'name' => '考证中'
            ],
            [
                'name' => '找基友'
            ],
            [
                'name' => '考研中',
            ],
            [
                'name' => '备考中',
            ],
            [
                'name' => '找闺蜜'
            ]
        ]);
    }
}
