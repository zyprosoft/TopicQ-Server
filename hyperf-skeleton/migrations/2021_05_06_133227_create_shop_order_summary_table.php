<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateShopOrderSummaryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shop_order_summary', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('shop_id')->comment('店铺ID');
            $table->text('summary_info')->comment('汇总信息');
            $table->tinyInteger('type')->default(0)->comment('汇总类型0:未发货1:已发货2:已完成');
            $table->integer('order_total')->comment('该类型总订单数');

            $table->unique(['shop_id', 'type'],'unique_type');
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
        Schema::dropIfExists('shop_order_summary');
    }
}
