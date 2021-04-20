<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserUpdateTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_update', function (Blueprint $table) {
            $table->bigIncrements('update_id');
            $table->bigInteger('user_id')->comment('用户ID');
            $table->string('avatar',500)->nullable()->comment('头像');
            $table->string('background',500)->nullable()->comment('背景');
            $table->string('nickname',20)->nullable()->comment('昵称');
            $table->tinyInteger('machine_audit')->default(0)->comment('机器审核结果:0待审核-1不通过1通过2建议人工复核');
            $table->tinyInteger('manager_audit')->default(0)->comment('管理员审核结果:0待审核-1不通过1通过');

            $table->index('user_id');
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
        Schema::dropIfExists('user_update');
    }
}
