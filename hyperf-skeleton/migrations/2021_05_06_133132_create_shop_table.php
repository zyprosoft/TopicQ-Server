<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateShopTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shop', function (Blueprint $table) {
            $table->bigIncrements('shop_id');
            $table->string('name',50)->comment('店铺名称');
            $table->string('address',128)->comment('店铺地址');
            $table->string('introduce',1000)->comment('店铺简介');
            $table->tinyInteger('type')->default(0)->comment('店铺类型,默认值0');
            $table->bigInteger('owner_id')->comment('店主用户ID');
            $table->tinyInteger('status')->default(1)->comment('店铺状态,0待发布;-1:拉黑;1:发布');
            $table->string('block_reason',128)->nullable()->comment('拉黑备注');
            $table->string('image',500)->comment('店铺图片');
            $table->unsignedInteger('base_deliver_price')->default(100)->comment('起送价格,单位分');
            $table->integer('open_time')->default(0)->comment('开始营业时间,整点,默认0点');
            $table->integer('close_time')->default(24)->comment('停止营业时间,整点,默认24点关');
            $table->string('phone_number',20)->comment('联系电话');
            $table->text('avatar_list')->nullable()->comment('最近四个下单用户的头像链接,分号分割');
            $table->integer('total_customer')->default(0)->comment('总客户数');
            $table->integer('total_order')->default(0)->comment('总订单数');
            $table->string('latest_order_list')->nullable()->comment('最近15单的订单编号列表，用分号分割');
            $table->unsignedInteger('wait_deliver_order_count')->default(0)->comment('等待送货订单数量');
            $table->string('qr_code',500)->nullable()->comment('小程序码链接地址');
            $table->unsignedInteger('platform_cut')->default(3)->comment('店铺平台特定抽成');
            $table->tinyInteger('audit_status')
                ->default(0)
                ->comment('店铺审核状态-1:不合规0:审核中1:合规');
            $table->string('audit_note',500)
                ->nullable()
                ->comment('店铺审核总体备注');
            $table->string('image_id',30)->nullable()->comment('图片ID');
            $table->string('printer_sn',128)
                ->nullable()
                ->comment('店铺绑定的打印机');
            $table->string('printer_key',128)
                ->nullable()
                ->comment('店铺绑定的打印机的key');

            //审核回调的时候需要快速查询
            $table->index('image_id');
            $table->index('owner_id');
            $table->index('status');
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
        Schema::dropIfExists('shop');
    }
}
