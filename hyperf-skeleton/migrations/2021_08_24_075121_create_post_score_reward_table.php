<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePostScoreRewardTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_score_reward', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->comment('打赏人');
            $table->bigInteger('post_owner_id')->comment('被打赏');
            $table->bigInteger('post_id')->comment('打赏的帖子或者动态');
            $table->bigInteger('amount')->comment('数量');

            $table->unique(['user_id','post_id']);//一个人打上帖子只能有一条记录,多次打赏采用叠加
            $table->index('post_owner_id');
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
        Schema::dropIfExists('post_score_reward');
    }
}
