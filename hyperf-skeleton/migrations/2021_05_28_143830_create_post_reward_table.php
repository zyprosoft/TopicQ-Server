<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePostRewardTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_reward', function (Blueprint $table) {
            $table->bigIncrements('reward_id');
            $table->bigInteger('owner_id')->comment('谁打赏的');
            $table->bigInteger('post_id')->comment('打赏的哪个帖子');
            $table->bigInteger('post_owner_id')->comment('打赏帖子的作者');
            $table->bigInteger('amount')->default(1)->comment('打赏的金额单位分');
            $table->string('order_no',30)->nullable()->comment('打赏时候的订单号,非钱包支付');

            $table->index('post_owner_id');
            $table->index('owner_id');
            $table->index('post_id');
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
        Schema::dropIfExists('post_reward');
    }
}
