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
            $table->bigInteger('voucher_id')->comment('券ID');
            $table->bigInteger('amount')->comment('金额');
            $table->tinyInteger('status')->default(0)->comment('0扣减-1:回滚');
            $table->dateTime('rollback_time')->nullable()->comment('回滚时间');
            $table->string('order_no',30)->comment('使用时候的订单号');
            $table->bigInteger('order_id')->comment('订单编号');

            $table->index('owner_id');
            $table->index('voucher_sn');
            $table->index('order_no');
            $table->index('status');
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
