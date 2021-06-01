<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class CreateSetupUnitAndCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Db::table('unit')->insertOrIgnore([
            ['name' => '次'],
            ['name' => '斤'],
            ['name' => '份'],
            ['name' => '个'],
            ['name' => '包'],
            ['name' => '盒'],
            ['name' => '瓶'],
            ['name' => '桶'],
            ['name' => '箱'],
            ['name' => 'L'],
            ['name' => '两'],
            ['name' => '年'],
            ['name' => '月'],
        ]);
    }
}
