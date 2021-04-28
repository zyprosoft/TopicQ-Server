<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterMiniProgramAddIndexPath extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mini_program', function (Blueprint $table) {
            //
            $table->string('index_path',64)->default('pages/index/index')->comment('跳转路径');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mini_program', function (Blueprint $table) {
            //
            $table->removeColumn('index_path');
        });
    }
}
