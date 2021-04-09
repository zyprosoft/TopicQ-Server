<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePrivateMessageTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('private_message', function (Blueprint $table) {
            $table->bigIncrements('message_id');
            $table->bigInteger('from_id')->comment('发出者');
            $table->bigInteger('receive_id')->comment('接受者');
            $table->string('content',500)->nullable()->comment('消息内容');
            $table->string('image',500)->nullable()->comment('图片内容');

            $table->index(['from_id','receive_id']);
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
        Schema::dropIfExists('private_message');
    }
}
