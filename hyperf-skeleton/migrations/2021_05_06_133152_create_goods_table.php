<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->bigIncrements('goods_id');
            $table->string('name',50)->comment('商品名称');
            $table->unsignedInteger('stock')->comment('库存');
            $table->integer('category_id')->comment('商品类目ID');
            $table->bigInteger('shop_id')->comment('店铺ID');
            $table->bigInteger('owner_id')->comment('所有者ID');
            $table->unsignedInteger('price')->comment('单价,单位分');
            $table->string('unit',10)->comment('单位');
            $table->string('image',500)->nullable()->comment('图片');
            $table->tinyInteger('status')->default(0)->comment('商品状态');
            $table->bigInteger('total_sale_count')->default(0)->comment('总售出数量');
            $table->string('labels',500)->nullable()->comment('标签');
            $table->string('desc',1000)->nullable()->comment('商品简介');

            $table->index('owner_id');
            $table->index('category_id');
            $table->index('status');
            $table->index('shop_id');
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
        Schema::dropIfExists('goods');
    }
}
