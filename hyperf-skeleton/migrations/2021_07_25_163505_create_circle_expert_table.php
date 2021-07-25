<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateCircleExpertTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('circle_expert', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('circle_id')->comment('圈子ID');
            $table->bigInteger('user_id')->comment('用户ID');
            $table->bigInteger('post_count')->comment('动态数量');
            $table->bigInteger('comment_count')->comment('评论数量');
            $table->bigInteger('praise_count')->comment('动态被点赞数量');
            $table->bigInteger('favorite_count')->comment('动态被收藏数量');
            $table->bigInteger('recommend')->default(0)->comment('推荐权重');

            $table->unique(['circle_id','user_id']);
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
        Schema::dropIfExists('circle_expert');
    }
}
