<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterAddForumActivity extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('activity', function (Blueprint $table) {
            //
            $table->tinyInteger('show_type')->default(0)->comment('0首页运营活动1版块运营活动');
            $table->bigInteger('forum_id')->default(0)->comment('当活动类型为版块活动的时候填充版块ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity', function (Blueprint $table) {
            //
            $table->dropColumn('show_type');
            $table->dropColumn('forum_id');
        });
    }
}
