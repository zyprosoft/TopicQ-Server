<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateTopicTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('topic', function (Blueprint $table) {
            $table->bigIncrements('topic_id');
            $table->string('title',64)->comment('话题标题');
            $table->string('introduce',128)->comment('话题介绍');
            $table->bigInteger('owner_id')->comment('谁创建的');
            $table->string('image',500)->comment('图片');
            $table->string('location',64)->nullable()->comment('位置');
            $table->bigInteger('category_id')->default(1)->comment('分类');
            $table->bigInteger('read_count')->default(0)->comment('阅读数');
            $table->bigInteger('join_count')->default(0)->comment('参与人数');
            $table->bigInteger('post_count')->default(0)->comment('帖子数');
            $table->bigInteger('comment_count')->default(0)->comment('评论数');

            $table->unique('title');
            $table->index('category_id');
            $table->index('owner_id');
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('topic');
    }
}
