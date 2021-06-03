<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateQqMiniProgramTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('qq_mini_program', function (Blueprint $table) {
            $table->bigIncrements('program_id');
            $table->string('app_id',48)->comment('小程序appId');
            $table->string('icon',500)->comment('图标');
            $table->string('name',64)->comment('名字');
            $table->string('introduce',500)->nullable()->comment('介绍');
            $table->integer('category_id')->comment('分类ID');
            $table->string('owner_name',64)->nullable()->comment('主体官方名字');
            $table->string('address',500)->nullable()->comment('主体的地址');
            $table->string('phone_number',64)->nullable()->comment('主体的座机');
            $table->string('mobile',64)->nullable()->comment('主体的手机信息');
            $table->string('owner_contact_name',64)->nullable()->comment('主体联系人名字');
            $table->string('open_time',64)->nullable()->comment('主体的经营时间');
            $table->bigInteger('create_user_id')->nullable()->comment('创建者ID');
            $table->bigInteger('update_user_id')->nullable()->comment('更新者ID');
            $table->string('index_path',64)->nullable()->comment('跳转路径');

            $table->unique('app_id');
            $table->index('owner_name');
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
        Schema::dropIfExists('qq_mini_program');
    }
}
