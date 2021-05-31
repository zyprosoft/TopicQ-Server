<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePostDocumentTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_document', function (Blueprint $table) {
            $table->bigIncrements('document_id');
            $table->bigInteger('post_id')->comment('帖子ID');
            $table->string('title',64)->comment('文档标题');
            $table->string('type',24)->comment('文档类型');
            $table->string('icon')->nullable()->comment('文档图标');
            $table->string('link',128)->comment('腾讯文档链接');
            $table->string('jump_path',500)->comment('跳转小程序链接');

            $table->index('post_id');
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
        Schema::dropIfExists('post_document');
    }
}
