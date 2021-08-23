<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterUserAddStatus extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user', function (Blueprint $table) {
            //
            $table->string('sign_status',24)->nullable()->comment('当前状态');
        });
        Schema::create('sign_status',function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('name',24);

            $table->unique('name');
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
        Schema::table('user', function (Blueprint $table) {
            //
            $table->dropColumn('sign_status');
        });
        Schema::drop('sign_status');
    }
}
