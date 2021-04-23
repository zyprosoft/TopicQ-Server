<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterUserPraiseCommentAddCommentOwner extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_comment_praise', function (Blueprint $table) {
            //
            $table->tinyInteger('owner_read_status')->default(0)->comment('评论归属者阅读状态');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_comment_praise', function (Blueprint $table) {
            //
            $table->removeColumn('owner_read_status');
        });
    }
}
