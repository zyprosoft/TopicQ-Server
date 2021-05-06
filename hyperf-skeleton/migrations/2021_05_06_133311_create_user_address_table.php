<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserAddressTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->comment('用户ID');
            $table->string('nickname',20)->comment('收货人');
            $table->integer('postal_code')->comment('邮政编码');
            $table->string('province',30)->comment('省份');
            $table->string('city',50)->comment('城市');
            $table->string('country',50)->comment('县区');
            $table->string('detail_info',128)->comment('详细地址');
            $table->string('national_code',20)->nullable()->comment('国家编号');
            $table->string('phone_number',20)->comment('联系电话');

            $table->unique(['nickname','city','country','detail_info','phone_number'],'unique_info');
            $table->index('owner_id');
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
        Schema::dropIfExists('user_address');
    }
}
