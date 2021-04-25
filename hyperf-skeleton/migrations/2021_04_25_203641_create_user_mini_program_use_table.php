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
        Schema::create('user_mini_program_use', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->comment('用户ID');
            $table->bigInteger('program_id')->comment('小程序记录ID');
            $table->integer('count')->default(0)->comment('使用次数');
            $table->tinyInteger('is_outside')->default(0)->comment('是否外显到我的页面');

            $table->index('user_id');
            $table->unique(['user_id','program_id',]);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = "InnoDB";
            $table->charset = "utf8mb4";
            $table->collation = "utf8mb4_unicode_ci";
        });

        Schema::create('user_official_account_use', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->comment('用户ID');
            $table->bigInteger('account_id')->comment('公众号记录ID');
            $table->integer('count')->default(0)->comment('使用次数');

            $table->index('user_id');
            $table->unique(['user_id','account_id',]);
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
        Schema::dropIfExists('user_mini_program_use');
        Schema::dropIfExists('user_official_account_use');
    }
}
