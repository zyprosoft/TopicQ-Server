<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateCircleTopicTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('circle_topic', function (Blueprint $table) {
            $table->bigIncrements('topic_id');
            $table->string('title',12)->comment('话题名字');
            $table->bigInteger('owner_id')->comment('创建者');
            $table->bigInteger('circle_id')->comment('圈子ID');

            $table->index('circle_id');
            $table->index('owner_id');
            $table->unique(['title','circle_id']);
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
        Schema::dropIfExists('circle_topic');
    }
}
