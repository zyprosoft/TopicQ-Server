<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterCommentAddSuper extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('comment', function (Blueprint $table) {
            //
            $table->string('audio_url',128)->nullable()->comment('音频链接');
            $table->bigInteger('super_comment_id')->default(0)->comment('最初的评论ID');
            $table->bigInteger('super_comment_owner_id')->default(0)->comment('最初评论的作者');
            $table->index('super_comment_id');
            $table->index('super_comment_owner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comment', function (Blueprint $table) {
            //
            $table->dropColumn('audio_url');
            $table->dropColumn('super_comment_id');
            $table->dropColumn('super_comment_owner_id');
        });
    }
}
