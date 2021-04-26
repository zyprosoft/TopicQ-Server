<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserSubscribeTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_subscribe', function (Blueprint $table) {
            $table->bigIncrements('subscribe_id');
            $table->bigInteger('user_id')->comment('用户ID');
            $table->bigInteger('forum_id')->comment('板块ID');

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
        Schema::dropIfExists('user_subscribe');
    }
}
