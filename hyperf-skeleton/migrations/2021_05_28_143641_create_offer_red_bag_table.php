<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateOfferRedBagTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offer_red_bag', function (Blueprint $table) {
            $table->bigIncrements('offer_id');
            $table->bigInteger('red_bag_id')->comment('红包ID');
            $table->bigInteger('amount')->comment('金额，单位分');
            $table->bigInteger('owner_id')->default(0)->comment('归属人ID,0为未分给用户');
            $table->dateTime('expire_time')->nullable()->comment('过期时间,没有就是没过期时间');
            $table->tinyInteger('status')->default(0)->comment('状态0正常-1作废');

            $table->index('status');
            $table->index('owner_id');
            $table->index('red_bag_id');
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
        Schema::dropIfExists('offer_red_bag');
    }
}
