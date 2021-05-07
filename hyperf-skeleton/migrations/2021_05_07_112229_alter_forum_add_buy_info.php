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
            $table->integer('max_member_count')->default(0)->comment('最多订阅用户0为不限制');
            $table->tinyInteger('need_buy')->default(0)->comment('是否需要付费0否1是');
            $table->tinyInteger('need_auth')->default(0)->comment('是否需要密码授权');
            $table->bigInteger('price')->default(0)->comment('付费价格单位分');
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
            $table->removeColumn('password');
            $table->removeColumn('max_member_count');
            $table->removeColumn('need_buy');
            $table->removeColumn('need_auth');
            $table->removeColumn('price');
            $table->removeColumn('buy_tip');
        });
    }
}
