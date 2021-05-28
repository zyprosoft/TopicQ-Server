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
            $table->string('bind_action',64)->comment('绑定的行为码');
            $table->string('name',12)->comment('行为名称描述');
            $table->integer('score')->default(1)->comment('积分值默认1');
            $table->tinyInteger('day_once')->default(0)->comment('是否每天限制一次');
            $table->tinyInteger('is_system')->default(0)->comment('是否系统设定的行为');
            $table->bigInteger('creator')->default(0)->comment('创建者ID,系统初始化的为0');

            $table->unique('bind_action');
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
