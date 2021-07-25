<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterCircleTopicAddPostCount extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('circle_topic', function (Blueprint $table) {
            //
            $table->bigInteger('post_count')->default(0)->comment('帖子数');
            $table->bigInteger('member_count')->default(0)->comment('话题参与人数');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('circle_topic', function (Blueprint $table) {
            //
            $table->dropColumn('post_count');
            $table->dropColumn('member_count');
        });
    }
}
