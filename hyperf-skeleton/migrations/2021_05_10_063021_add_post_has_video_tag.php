<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AddPostHasVideoTag extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('post', function (Blueprint $table) {
            //
            $table->tinyInteger('has_video')->default(0)->comment('是否包含视频');
            $table->tinyInteger('is_video_admin')->default(0)->comment('视频是不是管理员的');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post', function (Blueprint $table) {
            //
            $table->dropColumn('has_video');
            $table->dropColumn('is_video_admin');
        });
    }
}
