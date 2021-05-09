<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateVoucherTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('voucher', function (Blueprint $table) {
            $table->bigIncrements('voucher_id');
            $table->bigInteger('activity_id')->comment('活动ID');
            $table->bigInteger('policy_id')->comment('批次ID');
            $table->bigInteger('policy_goods_id')->nullable()->comment('适用商品ID,没有为全部适用');
            $table->bigInteger('policy_black_id')->nullable()->comment('不适用商品ID,没有为不拉黑');
            $table->string('voucher_sn',64)->comment('代金券编码');
            $table->tinyInteger('status')->default(0)->comment('0待适用1已使用-1已作废');
            $table->bigInteger('owner_id')->default(0)->comment('归属者ID,为0的时候说明没有归属，可以后续绑定');
            $table->bigInteger('left_amount')->comment('剩余面值单位分');
            $table->dateTime('begin_time')->nullable()->comment('生效开始时间，绑定归属者之后产生');
            $table->dateTime('end_time')->nullable()->comment('过期时间，绑定归属者之后产生');
            $table->dateTime('used_time')->nullable()->comment('使用时间，多次使用为最后一次使用时间');

            $table->unique('voucher_sn');
            $table->index('activity_id');
            $table->index('policy_id');
            $table->index('policy_goods_id');
            $table->index('status');
            $table->index('owner_id');
            $table->index('begin_time');
            $table->index('end_time');
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
        Schema::dropIfExists('voucher');
    }
}
