<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreatePlatformCutTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('platform_cut', function (Blueprint $table) {
            $table->bigIncrements('cut_id');
            $table->string('code')->comment('抽成的代码');
            $table->string('name',32)->comment('抽成项目名字');
            $table->string('desc',64)->comment('抽成描述');
            $table->integer('percentage')->comment('抽成百分比');
            $table->bigInteger('update_user')->comment('更新的用户');

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
        Schema::dropIfExists('platform_cut');
    }
}
