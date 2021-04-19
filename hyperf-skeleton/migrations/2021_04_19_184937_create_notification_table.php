<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->bigIncrements('message_id');
            $table->bigInteger('user_id')->comment('用户ID');
            $table->string('title',30)->comment('通知标题');
            $table->text('content')->comment('通知内容');
            $table->tinyInteger('is_top')->default(0)->comment('是否置顶0:否1:是');
            $table->tinyInteger('is_read')->default(0)->comment('是否已读0:否1:是');
            $table->tinyInteger('level')->default(0)->comment('级别0:普通1:提醒2:错误:3:严重4:拉黑');
            $table->string('level_label',2)->nullable()->comment('自定义通知标签名');

            $table->index('user_id');
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
        Schema::dropIfExists('notification');
    }
}
