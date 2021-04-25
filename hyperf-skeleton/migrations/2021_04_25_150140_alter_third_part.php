<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterThirdPart extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mini_program', function (Blueprint $table) {
            //
            $table->tinyInteger('is_recommend')->default(0)->comment('0否1是');
            $table->string('short_name',24)->comment('缩略名字');
        });
        Schema::table('official_account', function (Blueprint $table) {
            //
            $table->tinyInteger('is_recommend')->default(0)->comment('0否1是');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mini_program', function (Blueprint $table) {
            //
            $table->removeColumn('is_recommend');
            $table->removeColumn('short_name');
        });
        Schema::table('official_account', function (Blueprint $table) {
            //
            $table->removeColumn('is_recommend');
        });
    }
}
