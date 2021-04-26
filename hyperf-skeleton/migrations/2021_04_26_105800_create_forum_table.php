<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateForumTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('forum', function (Blueprint $table) {
            $table->bigIncrements('forum_id')->comment('板块ID');
            $table->tinyInteger('type')->default(0)->comment('0主板块1子板块');
            $table->bigInteger('parent_forum_id')->default(1)->comment('父板块ID');
            $table->string('icon',256)->comment('板块图标');
            $table->string('name',24)->comment('板块名称');
            $table->string('area',24)->nullable()->comment('板块归属区县');
            $table->string('country',24)->nullable()->comment('板块归属乡镇');
            $table->integer('sort_index')->default(0)->comment('排序索引，数字越大优先级越高');
            $table->integer('total_child_count')->default(0)->comment('子板块总数');
            $table->integer('total_post_count')->default(0)->comment('帖子总数');
            $table->string('notice',256)->nullable()->comment('板块公告');

            $table->index('type');
            $table->index('parent_forum_id');
            $table->index('area');
            $table->index('country');
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
        Schema::dropIfExists('forum');
    }
}
