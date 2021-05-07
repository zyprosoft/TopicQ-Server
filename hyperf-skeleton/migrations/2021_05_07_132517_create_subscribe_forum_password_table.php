<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateSubscribeForumPasswordTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscribe_forum_password', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unlock_sn_no',64)->comment('解锁的密钥串');
            $table->bigInteger('forum_id')->comment('绑定的板块');
            $table->tinyInteger('status')->comment('0未使用1已使用');
            $table->bigInteger('owner_id')->comment('被谁领取了');
            $table->bigInteger('price')->default(0)->comment('钥匙串价值单位分0不重要>0需要显示');

            $table->unique('unlock_sn_no');
            $table->index('forum_id');
            $table->index('status');
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
        Schema::dropIfExists('subscribe_forum_password');
    }
}
