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
            $table->bigInteger('post_owner_id')->default(0)->comment('帖主');
            $table->tinyInteger('owner_read_status')->default(0)->comment('帖主已读状态');
            $table->index('owner_read_status');
            $table->index('post_owner_id');
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
        });
    }
}
