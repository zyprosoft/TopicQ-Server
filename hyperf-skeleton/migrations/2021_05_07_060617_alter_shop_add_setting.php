<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterShopAddSetting extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shop', function (Blueprint $table) {
            //
            $table->tinyInteger('self_mall_use_recommend')->default(0)->comment('自营店铺是否开启外部商品导购');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop', function (Blueprint $table) {
            //
            $table->removeColumn('self_mall_use_recommend');
        });
    }
}
