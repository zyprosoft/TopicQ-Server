<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateOfficialAccountCategoryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('official_account_category', function (Blueprint $table) {
            $table->integerIncrements('category_id');
            $table->string('name',24)->comment('分类名称');
            $table->string('icon',500)->comment('分类图标');
            $table->integer('total')->default(0)->comment('当前分类下总数');
            $table->bigInteger('create_user_id')->nullable()->comment('创建者');
            $table->bigInteger('update_user_id')->nullable()->comment('更新者');

            $table->unique('name');
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
        Schema::dropIfExists('official_account_category');
    }
}
