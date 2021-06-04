<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterUserAddQqInfo extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user', function (Blueprint $table) {
            //
            $table->string('qq_token',64)->nullable()->comment('qq登录Token');
            $table->string('qq_openid',64)->nullable()->comment('qq登录openid');
            $table->dateTime('qq_token_expire')->nullable()->comment('qq登录Token过期时间');

            $table->string('baidu_token',64)->nullable()->comment('百度小程序Token');
            $table->string('baidu_openid',64)->nullable()->comment('百度openid');
            $table->dateTime('baidu_token_expire')->nullable()->comment('百度token过期时间');

            $table->string('byte_token',64)->nullable()->comment('字节登录Token');
            $table->string('byte_openid',64)->nullable()->comment('字节openid');
            $table->dateTime('byte_token_expire')->nullable()->comment('字节Token过期时间');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            //
            $table->dropColumn('qq_token');
            $table->dropColumn('qq_openid');
            $table->dropColumn('qq_token_expire');

            $table->dropColumn('baidu_token');
            $table->dropColumn('baidu_openid');
            $table->dropColumn('baidu_token_expire');

            $table->dropColumn('byte_token');
            $table->dropColumn('byte_openid');
            $table->dropColumn('byte_token_expire');
        });
    }
}
