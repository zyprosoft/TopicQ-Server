<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserMiniProgramUseTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_third_part_use', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->comment('用户ID');
            $table->tinyInteger('third_part_type')->default(0)->comment('第三方使用类型0小程序1公众号');
            $table->bigInteger('third_part_id')->comment('第三方类型ID');
            $table->integer('count')->default(0)->comment('使用次数');
            $table->tinyInteger('is_outside')->default(0)->comment('是否外显到我的页面,只支持小程序');

            $table->index('user_id');
            $table->unique(['user_id','third_part_id']);
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
        Schema::dropIfExists('user_third_part_use');
    }
}
