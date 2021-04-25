<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateMiniProgramTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mini_program', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('app_id',48)->comment('小程序appId');
            $table->string('icon',500)->comment('图标');
            $table->string('name',64)->comment('名字');
            $table->integer('category_id')->comment('分类ID');
            $table->string('address',500)->comment('主体的地址');
            $table->string('phone_number',64)->comment('主体的座机');
            $table->string('mobile',64)->comment('主体的手机信息');
            $table->string('owner_nickname',64)->comment('主体联系人名字');
            $table->string('open_time',64)->comment('主体的经营时间');
            $table->bigInteger('create_user_id')->nullable()->comment('创建者ID');
            $table->bigInteger('update_user_id')->nullable()->comment('更新者ID');

            $table->unique('app_id');
            $table->index('category_id');
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
        Schema::dropIfExists('mini_program');
    }
}
