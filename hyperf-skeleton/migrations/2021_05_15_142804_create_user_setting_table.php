<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserSettingTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_setting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->comment('用户ID');
            $table->tinyInteger('open_private_message')->default(1)->comment('默认打开接收私信');

            $table->unique('owner_id');
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
        Schema::dropIfExists('user_setting');
    }
}
