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
            $table->bigIncrements('policy_id');
            $table->string('introduce',32)->nullable()->comment('本次授权的介绍');
            $table->string('sn_prefix',16)->comment('本次发布的授权码前缀');
            $table->bigInteger('forum_id')->comment('绑定的板块');
            $table->tinyInteger('status')->comment('0待领取1已领完-1已作废');
            $table->bigInteger('price')->default(0)->comment('钥匙串价值单位分0不重要>0需要显示');
            $table->integer('total_count')->default(0)->comment('总共可以生成多少张授权');
            $table->integer('left_count')->default(0)->comment('剩余多少张可授权');

            $table->index('forum_id');
            $table->index('status');
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
