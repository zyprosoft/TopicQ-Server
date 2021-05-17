<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterAppSettingAddEnableUserVideo extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('app_setting', function (Blueprint $table) {
            //
            $table->tinyInteger('enable_user_video')->default(0)->comment('是否开启普通用户可以发视频0不允许1允许');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_setting', function (Blueprint $table) {
            //
            $table->dropColumn('enable_user_video');
        });
    }
}
