<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateCashLogTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cash_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->comment('行为用户');
            $table->tinyInteger('type')->default(0)->comment('行为0:支出1:收入2:提现');
            $table->unsignedBigInteger('cash')->default(0)->comment('金额，单位分');
            $table->unsignedBigInteger('platform_cut')->default(0)->comment('收入时候平台抽成');
            $table->string('order_no',30)->nullable()->comment('关联的订单');
            $table->string('note',200)->nullable()->comment('备注');

            $table->index('owner_id');
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
        Schema::dropIfExists('cash_log');
    }
}
