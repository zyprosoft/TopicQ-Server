<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateGoodsCategoryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('goods_category', function (Blueprint $table) {
            $table->bigIncrements('category_id');
            $table->string('name',50)->comment('分类名称');
            $table->bigInteger('create_user')->comment('创建者');
            $table->string('note',200)->nullable()->comment('备注');
            $table->string('image',500)->nullable()->comment('图片');
            $table->bigInteger('shop_id')->default(-1)->comment('店铺ID，系统分类此店铺ID为-1');

            $table->unique(['name','shop_id']);
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
        Schema::dropIfExists('goods_category');
    }
}
