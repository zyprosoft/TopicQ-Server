<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserCircleInfoTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_circle', function (Blueprint $table) {
            $table->dateTime('last_active_time')->nullable()->comment('最后活跃时间');
            $table->integer('post_count')->default(0)->comment('发表的动态数量');
            $table->integer('comment_count')->default(0)->comment('发表的评论数量');
            $table->integer('topic_count')->default(0)->comment('发表的话题数量');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_circle', function (Blueprint $table) {
            $table->dropColumn('last_active_time');
            $table->dropColumn('post_count');
            $table->dropColumn('comment_count');
            $table->dropColumn('topic_count');
        });
    }
}
