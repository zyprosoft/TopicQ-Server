<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserGroupTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_group', function (Blueprint $table) {
            $table->bigIncrements('group_id');
            $table->string('name',12)->comment('分组名称');
            $table->string('label_color',12)->nullable()->comment('标签颜色');
            $table->tinyInteger('open_choose')->default(0)->comment('是否公开给用户选择,非公开的需要管理员设置');
            $table->tinyInteger('need_real_name')->default(0)->comment('是否需要实名才可绑定');
            $table->bigInteger('creator')->comment('创建者ID');

            $table->unique('name');
            $table->index('open_choose');
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
        Schema::dropIfExists('user_group');
    }
}
