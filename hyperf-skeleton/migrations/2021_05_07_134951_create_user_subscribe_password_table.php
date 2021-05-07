<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserSubscribePasswordTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_subscribe_password', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unlock_sn',64)->comment('最长64位的解锁码');
            $table->bigInteger('owner_id')->comment('归属谁');
            $table->tinyInteger('status')->default(0)->comment('0待使用1已使用');
            $table->bigInteger('policy_id')->comment('归属哪个批次');
            
            $table->unique(['unlock_sn','policy_id']);
            $table->index('owner_id');
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
        Schema::dropIfExists('user_subscribe_password');
    }
}
