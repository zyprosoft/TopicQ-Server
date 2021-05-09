<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateVoucherUseHistoryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('voucher_use_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->comment('归属者');
            $table->string('voucher_sn',64)->comment('券编码');
            $table->bigInteger('policy_id')->comment('批次ID');
            $table->bigInteger('policy_goods_id')->comment('适用商品ID');
            $table->bigInteger('policy_black_id')->comment('不适用商品ID');
            $table->bigInteger('amount')->comment('金额');
            $table->tinyInteger('type')->default(0)->comment('0扣减1:回滚');
            $table->string('order_no',30)->comment('使用时候的订单号');

            $table->index('owner_id');
            $table->index('voucher_sn');
            $table->index('policy_id');
            $table->index('order_no');
            $table->index('type');
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
        Schema::dropIfExists('voucher_use_history');
    }
}
