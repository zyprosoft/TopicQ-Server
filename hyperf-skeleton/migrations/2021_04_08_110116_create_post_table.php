<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post', function (Blueprint $table) {
            $table->bigIncrements('post_id');
            $table->string('title',48)->comment('标题');
            $table->string('summary',32)->comment('概要');
            $table->text('content')->comment('内容');
            $table->text('image_list')->nullable()->comment('图片列表');
            $table->bigInteger('owner_id')->comment('作者');
            $table->string('link',500)->nullable()->comment('超链接');
            $table->bigInteger('vote_id')->nullable()->comment('投票信息');
            $table->bigInteger('read_count')->default(0)->comment('阅读数');
            $table->integer('favorite_count')->default(0)->comment('收藏数');
            $table->integer('forward_count')->default(0)->comment('转发数');
            $table->integer('comment_count')->default(0)->comment('评论数');
            $table->tinyInteger('audit_status')->default(0)->comment('0审核中1:审核通过-1:审核不通过');
            $table->string('audit_note')->nullable()->comment('审核备注');
            $table->tinyInteger('is_hot')->default(0)->comment('是否热门帖子0否1是');
            $table->dateTime('last_comment_time')->nullable()->comment('最新一条评论的时间');
            $table->integer('sort_index')->default(0)->comment('排序置顶用');
            $table->tinyInteger('is_recommend')->default(0)->comment('是否推荐帖');
            $table->integer('unread_comment_count')->default(0)->comment('帖子作者未看评论数量');

            $table->index('owner_id');
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
        Schema::dropIfExists('post');
    }
}
