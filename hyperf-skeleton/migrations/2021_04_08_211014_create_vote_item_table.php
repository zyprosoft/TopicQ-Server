<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateVoteItemTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vote_item', function (Blueprint $table) {
            $table->bigIncrements('vote_item_id');
            $table->bigInteger('vote_id')->comment('投票ID');
            $table->string('content',32)->comment('选项内容');
            $table->integer('user_count')->comment('此选项的用户数量');

            $table->index('vote_id');
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
        Schema::dropIfExists('vote_item');
    }
}
