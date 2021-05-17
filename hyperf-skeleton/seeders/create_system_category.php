<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class CreateSystemCategory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('goods_category')->insertOrIgnore([
           [ 'name' => '订阅商品'],
        ]);
        Db::table('topic_category')->insertOrIgnore([
            ['name' => '公共'],
        ]);
    }
}
