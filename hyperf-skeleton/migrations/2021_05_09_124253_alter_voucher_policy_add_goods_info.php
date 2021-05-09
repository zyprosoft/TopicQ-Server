<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterVoucherPolicyAddGoodsInfo extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('voucher_policy', function (Blueprint $table) {
            //
            $table->bigInteger('policy_goods_id')->nullable()->comment('适用商品ID,没有为全部适用');
            $table->bigInteger('policy_black_id')->nullable()->comment('不适用商品ID,没有为不拉黑');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voucher_policy', function (Blueprint $table) {
            //
            $table->dropColumn('policy_goods_id');
            $table->dropColumn('policy_black_id');
        });
    }
}
