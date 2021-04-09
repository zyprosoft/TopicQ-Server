<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comment', function (Blueprint $table) {
            $table->bigIncrements('comment_id');
            $table->bigInteger('post_id')->default(0)->comment('帖子ID');
            $table->bigInteger('parent_comment_id')->nullable()->comment('回复的评论');
            $table->bigInteger('parent_comment_owner_id')->nullable()->comment('原评论的作者ID');
            $table->tinyInteger('parent_comment_owner_is_read')->default(0)->comment('原评论作者是否已经看过此条评论0:未读1:已读');
            $table->bigInteger('owner_id')->comment('作者ID');
            $table->string('content',500)->comment('回复内容');
            $table->string('link',500)->nullable()->comment('回复的超链接');
            $table->text('image_list')->nullable()->comment('回复的图片列表');
            $table->integer('praise_count')->default(0)->comment('点赞数量');
            $table->integer('reply_count')->default(0)->comment('回复数量');
            $table->tinyInteger('audit_status')->default(0)->comment('0审核中1:审核通过-1:审核不通过');
            $table->string('audit_note')->nullable()->comment('审核备注');
            $table->tinyInteger('is_hot')->default(0)->comment('是否热评，0否1是');

            $table->index('post_id');
            $table->index('owner_id');
            $table->index('parent_comment_owner_id');
            $table->index('parent_comment_owner_is_read');
            $table->index('audit_status');
            $table->softDeletes();
            $table->timestamps();
            $table->engine = "InnoDB";
            $table->charset = "utf8mb4";
            $table->collation = "utf8mb4_unicode_ci";
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment');
    }
}
