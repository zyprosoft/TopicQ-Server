<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterAppSettingAddTopicEnable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('app_setting', function (Blueprint $table) {
            //
            $table->tinyInteger('enable_user_create_topic')->default(0)->comment('是否允许普通用户创建主题');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_setting', function (Blueprint $table) {
            //
            $table->dropColumn('enable_user_create_topic');
        });
    }
}
