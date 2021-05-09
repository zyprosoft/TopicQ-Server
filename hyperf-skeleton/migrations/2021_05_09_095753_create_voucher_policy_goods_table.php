<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateVoucherPolicyGoodsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('voucher_policy_goods', function (Blueprint $table) {
            $table->bigIncrements('policy_goods_id');
            $table->string('category_list',1000)->nullable()->comment('适用产品类别，多个ID使用逗号分割,没有goods_list的时候说明是类别适用');
            $table->string('goods_list',1000)->nullable()->comment('适用具体产品，当有指定产品列表的时候，就不存在为类别通用');

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
        Schema::dropIfExists('voucher_policy_goods');
    }
}
