<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterForumAddBuyInfo extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('forum', function (Blueprint $table) {
            //
            $table->tinyInteger('need_auth')->default(0)->comment('是否需要密码授权');
            $table->bigInteger('goods_id')->default(0)->comment('绑定商品的ID');
            $table->string('buy_tip',500)->comment('付费提示内容');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum', function (Blueprint $table) {
            //
            $table->dropColumn('need_auth');
            $table->dropColumn('goods_id');
            $table->dropColumn('buy_tip');
        });
    }
}
