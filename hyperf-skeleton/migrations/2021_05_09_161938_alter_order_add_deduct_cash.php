<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterOrderAddDeductCash extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order', function (Blueprint $table) {
            //
            $table->bigInteger('deduct_cash')->default(0)->comment('券抵扣金额,单位分');
            $table->bigInteger('voucher_id')->default(0)->comment('券ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order', function (Blueprint $table) {
            //
//            $table->dropColumn('deduct_cash');
//            $table->dropColumn('voucher_id');
        });
    }
}
