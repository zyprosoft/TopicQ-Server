<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateRedBagTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('red_bag', function (Blueprint $table) {
            $table->bigIncrements('red_bag_id');
            $table->string('name',32)->comment('红包名字');
            $table->string('desc',128)->comment('红包描述');
            $table->bigInteger('amount')->comment('红包金额，单位分');
            $table->integer('slice_count')->default(1)->comment('分多少个');
            $table->integer('is_average')->default(0)->comment('是否平分金额');
            $table->string('order_no',30)->nullable()->comment('支付订单号,非钱包支付的时候有这个');
            $table->string('pay_type',10)->default('weixin')->comment('支付方式,钱包或者微信等,默认微信');
            $table->tinyInteger('finish_slice')->default(0)->comment('是否分割完成');
            $table->tinyInteger('status')->default(0)->comment('红包状态0正常-1失效');
            $table->integer('time_span')->default(0)->comment('时效,为0的时候说明没有过期时间');
            $table->string('time_unit')->default('p')->comment('时间单位p分钟h小时d天m月y年');
            $table->bigInteger('creator')->comment('创建红包的人');

            $table->index('status');
            $table->unique('name');
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
        Schema::dropIfExists('red_bag');
    }
}
