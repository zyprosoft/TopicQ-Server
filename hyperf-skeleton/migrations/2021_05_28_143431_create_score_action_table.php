<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateScoreActionTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('score_action', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',12)->comment('行为名称');
            $table->integer('score')->default(1)->comment('积分值默认1');
            $table->tinyInteger('day_once')->default(0)->comment('是否每天限制一次');
            $table->tinyInteger('is_system')->default(0)->comment('是否系统设定的行为');
            $table->string('bind_module',64)->nullable()->comment('绑定触发的大模块，需要是非系统设定的行为才能填充');
            $table->string('bind_module_action',24)->nullable()->comment('绑定触发的具体方法名，需要是非系统设定的行为才能填充');
            $table->bigInteger('creator')->default(0)->comment('创建者ID,系统初始化的为0');

            $table->unique('name');
            $table->index('is_system');
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
        Schema::dropIfExists('score_action');
    }
}
