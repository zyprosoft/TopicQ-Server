<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterOrderAddOriginCash extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order', function (Blueprint $table) {
            //
            $table->bigInteger('origin_cash')->default(0)->comment('抵扣钱订单金额');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order', function (Blueprint $table) {
            //
            $table->dropColumn('origin_cash');
        });
    }
}
