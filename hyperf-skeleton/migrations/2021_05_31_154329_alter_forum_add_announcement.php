<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterForumAddAnnouncement extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('forum', function (Blueprint $table) {
            //
            $table->string('announcement',500)->nullable()->comment('公告');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum', function (Blueprint $table) {
            //
            $table->dropColumn('announcement');
        });
    }
}
