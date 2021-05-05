<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterPostAddMallGoods extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('post', function (Blueprint $table) {
            //
            $table->tinyInteger('mall_type')->default(0)->comment('0:拼多多1:京东');
            $table->text('mall_goods')->nullable()->comment('关联的商品信息');
            $table->text('mall_goods_buy_info')->nullable()->comment('商品购买跳转信息');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post', function (Blueprint $table) {
            //
            $table->removeColumn('mall_type');
            $table->removeColumn('mall_goods');
            $table->removeColumn('mall_goods_buy_info');
        });
    }
}
