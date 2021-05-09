<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateVoucherPolicyBlackGoodsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('voucher_policy_black_goods', function (Blueprint $table) {
            $table->bigIncrements('policy_black_id');
            $table->bigInteger('activity_id')->comment('活动ID');
            $table->bigInteger('policy_id')->comment('批次ID');
            $table->string('category_list',1000)->nullable()->comment('拉黑产品类别，多个ID使用逗号分割,没有goods_list的时候说明是类别下全部拉黑');
            $table->string('goods_list',1000)->nullable()->comment('拉黑具体产品，当有指定产品列表的时候，就不存在为类别全部拉黑');

            $table->index('activity_id');
            $table->unique('policy_id'); //一个批次只能有一条拉黑记录
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
        Schema::dropIfExists('voucher_policy_black_goods');
    }
}
