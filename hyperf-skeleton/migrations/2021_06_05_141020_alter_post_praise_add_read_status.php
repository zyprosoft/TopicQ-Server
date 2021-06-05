<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterPostPraiseAddReadStatus extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_praise_post', function (Blueprint $table) {
            //
            $table->tinyInteger('owner_read_status')->default(0)->comment('帖主已读状态');
            $table->index('owner_read_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_praise_post', function (Blueprint $table) {
            //
            $table->dropColumn('owner_read_status');
            $table->dropColumn('post_owner_id');
        });
    }
}
