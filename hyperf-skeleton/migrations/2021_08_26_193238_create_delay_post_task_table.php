<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateDelayPostTaskTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delay_post_task', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('post_id')->comment('抓取的帖子ID');
            $table->bigInteger('forum_id')->default(0)->comment('需要发布的版块ID');
            $table->bigInteger('circle_id')->default(0)->comment('需要发布的圈子ID');
            $table->tinyInteger('is_active')->default(0)->comment('是不是动态');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delay_post_task');
    }
}
