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
            $table->bigInteger('comment_owner_id')->comment('评论归属作者');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_comment_praise', function (Blueprint $table) {
            //
            $table->removeColumn('comment_owner_id');
        });
    }
}
