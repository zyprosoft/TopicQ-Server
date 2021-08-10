<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterCircleTopicAddLastActive extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('circle_topic', function (Blueprint $table) {
            //
            $table->dateTime('last_active_time')->nullable();
            $table->integer('today_post_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('circle_topic', function (Blueprint $table) {
            //
            $table->dropColumn('last_active_time');
            $table->dropColumn('today_post_count');
        });
    }
}
