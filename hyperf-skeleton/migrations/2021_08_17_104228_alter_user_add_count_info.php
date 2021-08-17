<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterUserAddCountInfo extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user', function (Blueprint $table) {
            //
            $table->bigInteger('active_count')->default(0)->comment('动态数');
            $table->bigInteger('post_count')->default(0)->comment('帖子数');
            $table->bigInteger('fans_count')->default(0)->comment('粉丝数');
            $table->bigInteger('attention_count')->default(0)->comment('关注数');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            //
            $table->dropColumn('active_count');
            $table->dropColumn('post_count');
            $table->dropColumn('fans_count');
            $table->dropColumn('attention_count');
        });
    }
}
