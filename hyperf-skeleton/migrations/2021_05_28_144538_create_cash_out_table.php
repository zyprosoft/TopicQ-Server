<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateCashOutTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cash_out_apply', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->comment('用户ID');
            $table->string('mobile',11)->comment('提交者手机号');
            $table->bigInteger('amount')->comment('提现金额，单位分');
            $table->tinyInteger('admin_operate_result')->default(0)->comment('管理员操作结果0:待完成1:已完成-1:驳回请求');
            $table->string('reject_reason',256)->nullable()->comment('如果被驳回了，填充这个字段');
            $table->string('admin_operate_note',500)->nullable()->comment('管理员操作备注');
            $table->string('bank_order_info',500)->nullable()->comment('银行返回的订单信息，如果有的话填充一下');

            $table->index('owner_id');
            $table->index('mobile');
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
        Schema::dropIfExists('cash_out');
    }
}
