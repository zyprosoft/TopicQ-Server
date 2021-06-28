<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateJoinCircleApplyTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('join_circle_apply', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->comment('申请ID');
            $table->bigInteger('circle_id')->comment('圈子ID');
            $table->bigInteger('circle_owner_id')->comment('圈主ID');
            $table->string('note',64)->nullable()->comment('留言');
            $table->tinyInteger('audit_status')->default(0)->comment('0待审核1通过-1不通过');

            $table->index('circle_id');
            $table->index('user_id');
            $table->index('circle_owner_id');
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
        Schema::dropIfExists('join_circle_apply');
    }
}
