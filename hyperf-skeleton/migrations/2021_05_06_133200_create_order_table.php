<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('order_id');
            $table->string('order_no',30)->comment('订单号');
            $table->tinyInteger('pay_status')->default(0)->comment('订单状态0:未支付1:已支付');
            $table->tinyInteger('deliver_status')->default(0)->comment('送货状态0:未送货1:已送货');
            $table->bigInteger('owner_id')->comment('用户ID');
            $table->bigInteger('shop_owner_id')->comment('店铺用户ID');
            $table->bigInteger('shop_id')->comment('店铺ID');
            $table->unsignedInteger('cash')->comment('订单金额，单位分');
            $table->unsignedInteger('platform_cut')->comment('平台抽成，单位分');
            $table->string('address',128)->comment('收货地址');
            $table->string('mobile',11)->comment('收货人手机号');
            $table->string('nickname',20)->comment('收货人昵称');
            $table->string('customer_note',128)->nullable()->comment('客户备注');
            $table->tinyInteger('deliver_type')->default(0)->comment('发货形式0：送货1：自取');
            $table->tinyInteger('receive_status')->default(0)->comment('收货确认0:未确认1:确认');
            $table->tinyInteger('finish_status')->default(0)->comment('完成状态0:未完成1:已完成');
            $table->string('finish_note',128)->nullable()->comment('达到完成状态的备注');
            $table->tinyInteger('is_appreciate')->default(0)->comment('客户是否点赞');
            $table->dateTime('deliver_time')->nullable()->comment('发货时间');
            $table->dateTime('receive_time')->nullable()->comment('确认收货时间');
            $table->unsignedInteger('order_expire')->default(30)->comment('未支付订单过期时间，单位分钟,默认30分钟');
            $table->string('wx_prepay_id',64)->nullable()->comment('微信支付统一订单号');
            $table->dateTime('wx_prepay_id_time')->nullable()->comment('微信支付订单号生成时间');
            $table->string('pay_status_note',500)->nullable()->comment('支付状态变更备注');
            $table->string('wx_prepay_body',500)->nullable()->comment('微信支付申请统一订单时候的body');
            $table->dateTime('pay_time')->nullable()->comment('支付成功时间');
            $table->dateTime('pay_expire_time')->nullable()->comment('未支付状态下的过期时间');
            $table->tinyInteger('is_comment')->default(0)->comment('是否已点评订单0:否1:是');
            $table->string('print_order_id',128)->nullable()->comment('云打印机的返回的编号，如果打印了这个编号存在');
            $table->dateTime('print_time')->nullable()->comment('云打印成功的时间');

            $table->unique('order_no');
            $table->index('pay_status');
            $table->index('deliver_status');
            $table->index('finish_status');
            $table->index('receive_status');
            $table->index('owner_id');
            $table->index('shop_owner_id');
            $table->index('shop_id');
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
        Schema::dropIfExists('order');
    }
}
