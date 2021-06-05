<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserPraisePostTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_praise_post', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->comment('用户ID');
            $table->bigInteger('post_id')->comment('帖子ID');
            $table->tinyInteger('owner_read_status')->default(0)->comment('帖主已读状态');
            $table->tinyInteger('post_owner_id')->default(0)->comment('帖主');

            $table->index('post_owner_id');
            $table->index('owner_read_status');
            $table->unique(['user_id','post_id']);
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
        Schema::dropIfExists('user_praise_post');
    }
}
