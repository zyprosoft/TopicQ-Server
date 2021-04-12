<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateConversationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('conversation', function (Blueprint $table) {
            $table->bigIncrements('conversation_id');
            $table->bigInteger('owner_id')->comment('会话所有者');
            $table->bigInteger('to_user_id')->comment('会话对话人');
            $table->string('last_message',500)->comment('最后一条消息会话内容');
            $table->dateTime('last_message_time')->comment('最后一条消息时间');
            $table->integer('unread_count')->default(0)->comment('未读消息数');

            $table->unique(['owner_id', 'to_user_id']);
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
        Schema::dropIfExists('conversation');
    }
}
