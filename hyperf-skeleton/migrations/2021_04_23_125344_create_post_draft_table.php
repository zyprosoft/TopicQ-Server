<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePostDraftTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_draft', function (Blueprint $table) {
            $table->bigIncrements('draft_id');
            $table->string('title',48)->nullable()->comment('标题');
            $table->text('content')->nullable()->comment('内容');
            $table->text('image_list')->nullable()->comment('图片列表');
            $table->bigInteger('owner_id')->comment('作者');
            $table->string('link',500)->nullable()->comment('超链接');
            $table->text('vote')->nullable()->comment('投票信息json数据');

            $table->index('owner_id');
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
        Schema::dropIfExists('post_draft');
    }
}
