<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterAppSettingAddNavControl extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('app_setting', function (Blueprint $table) {
            //
            $table->tinyInteger('enable_nav_forum')->default(0)->comment('是否允许订阅版块提升到导航栏');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_setting', function (Blueprint $table) {
            //
            $table->dropColumn('enable_nav_forum');
        });
    }
}
