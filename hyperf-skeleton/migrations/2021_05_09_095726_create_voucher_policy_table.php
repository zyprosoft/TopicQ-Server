<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateVoucherPolicyTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('voucher_policy', function (Blueprint $table) {
            $table->bigIncrements('policy_id');
            $table->bigInteger('activity_id')->comment('归属活动');
            $table->string('sn_prefix',16)->comment('本批次授权码前缀');
            $table->bigInteger('total_count')->comment('总授权数量');
            $table->bigInteger('amount')->comment('券的面值，单位分');
            $table->bigInteger('left_count')->default(0)->comment('剩余可授权数量');
            $table->tinyInteger('multi_use')->default(0)->comment('是否可以多次使用0否1是');
            $table->bigInteger('base_amount')->default(0)->comment('大于0的时候为满减0为无门槛');
            $table->integer('time_span')->default(0)->comment('0为永久生效大于0则看生效单位');
            $table->string('time_unit',5)->nullable()->comment('与time_span配合使用p:分钟h:小时d:天m:月y:年');
            $table->tinyInteger('status')->default(0)->comment('0待生效1已生效-1已作废');

            $table->unique('sn_prefix');
            $table->index('activity_id');
            $table->index('multi_use');
            $table->index('status');
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
        Schema::dropIfExists('voucher_policy');
    }
}
