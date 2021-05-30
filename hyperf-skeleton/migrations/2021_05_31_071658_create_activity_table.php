<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateActivityTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity', function (Blueprint $table) {
            $table->bigIncrements('activity_id');
            $table->bigInteger('post_id')->default(0)->comment('如果是帖子设为活动');
            $table->string('jump_path',64)->nullable()->comment('内部跳转链接,三种类型必须要有一种');
            $table->string('jump_url',256)->nullable()->comment('跳转H5页面');
            $table->string('title',64)->comment('标题');
            $table->string('introduce',128)->comment('简介');
            $table->string('image')->comment('活动图片');
            $table->bigInteger('creator')->default(0)->comment('活动创建者');
            $table->tinyInteger('sort_index')->default(0)->comment('排序索引');
            $table->tinyInteger('status')->default(0)->comment('0正常-1停止');

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
        Schema::dropIfExists('activity');
    }
}
