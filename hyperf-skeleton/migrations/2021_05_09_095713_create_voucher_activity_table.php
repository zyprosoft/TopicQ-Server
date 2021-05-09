<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateVoucherActivityTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('voucher_activity', function (Blueprint $table) {
            $table->bigIncrements('activity_id');
            $table->string('name',64)->comment('活动名称');
            $table->string('introduce',500)->nullable()->comment('活动介绍');
            $table->string('image_list',500)->nullable()->comment('活动图片');
            $table->bigInteger('create_user')->comment('创建者ID');
            $table->dateTime('begin_time')->nullable()->comment('开始时间');
            $table->dateTime('end_time')->nullable()->comment('结束时间');
            $table->tinyInteger('status')->comment('0正常-1失效');

            $table->unique('name');
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
        Schema::dropIfExists('voucher_activity');
    }
}
