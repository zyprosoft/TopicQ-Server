<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterForumAddPagePath extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('forum', function (Blueprint $table) {
            //
            $table->string('page_path',64)->nullable()->comment('小程序内部跳转链接');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum', function (Blueprint $table) {
            //
            $table->dropColumn('page_path');
        });
    }
}
