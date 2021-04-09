<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateTokenHistoryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('token_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->comment('用户ID');
            $table->string('token',500)->comment('用过的token');
            $table->dateTime('token_expire')->comment('此token的过期时间');

            $table->index('token');
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
        Schema::dropIfExists('token_history');
    }
}
