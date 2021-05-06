<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_goods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_no',30);
            $table->bigInteger('goods_id')->comment('商品ID');
            $table->string('order_goods_name',50)->comment('下单时商品名字');
            $table->string('order_goods_image', 500)->comment('下单时商品图片');
            $table->unsignedInteger('count')->comment('数量');
            $table->unsignedInteger('order_price')->comment('购买时候的定价');
            $table->string('order_unit',10)->comment('购买时的单位');

            $table->unique(['order_no','goods_id']);
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
        Schema::dropIfExists('order_goods');
    }
}
