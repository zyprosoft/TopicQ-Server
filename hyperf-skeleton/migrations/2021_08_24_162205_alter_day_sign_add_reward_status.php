<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterDaySignAddRewardStatus extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_day_sign', function (Blueprint $table) {
            //
            $table->integer('reward_score')->default(0)->comment('当日签到抽奖积分');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_day_sign', function (Blueprint $table) {
            //
            $table->dropColumn('reward_score');
        });
    }
}
