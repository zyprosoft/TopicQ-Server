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
            $table->string('password',500)->nullable()->comment('密码');
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
            $table->dropColumn('password');
            $table->dropColumn('max_member_count');
            $table->dropColumn('need_buy');
            $table->dropColumn('need_auth');
            $table->dropColumn('price');
            $table->dropColumn('buy_tip');
        });
    }
}