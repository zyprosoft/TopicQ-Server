<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserUploadStatisticTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_upload_statistic', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->comment('用户ID');
            $table->date('upload_date')->comment('哪天上传的');
            $table->bigInteger('count')->comment('获取上传token的次数');
            $table->tinyInteger('disable')->default(0)->comment('今天是不是禁止上传了');

            $table->unique(['owner_id','upload_date']);//每天记录一次
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
        Schema::dropIfExists('user_upload_statistic');
    }
}
