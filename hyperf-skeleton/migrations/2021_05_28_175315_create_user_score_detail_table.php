<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserScoreDetailTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_score_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bind_action',64)->comment('绑定行为');
            $table->bigInteger('owner_id')->comment('用户');
            $table->integer('score')->comment('变化分数');
            $table->string('desc',128)->comment('加分描述');
            $table->string('key_info',1000)->comment('携带信息json');

            $table->index('bind_action');
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
        Schema::dropIfExists('user_score_detail');
    }
}
