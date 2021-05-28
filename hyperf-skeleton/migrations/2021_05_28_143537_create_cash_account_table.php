<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateCashAccountTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cash_account', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->comment('用户ID');
            $table->unsignedBigInteger('income')->default(0)->comment('用户总收入,单位分');
            $table->unsignedBigInteger('cash_out')->default(0)->comment('可提现金额,单位分');
            $table->unsignedBigInteger('will_income')->default(0)->comment('待归属金额,单位分');
            $table->tinyInteger('status')->default(0)->comment('账户状态.0:正常-1:被冻结');
            $table->string('block_reason',200)->nullable()->comment('冻结备注');

            $table->unique('owner_id');
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
        Schema::dropIfExists('cash_account');
    }
}
