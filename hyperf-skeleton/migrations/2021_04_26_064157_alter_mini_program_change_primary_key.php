<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterMiniProgramChangePrimaryKey extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mini_program', function (Blueprint $table) {
            //
            $table->removeColumn('id');
            $table->bigIncrements('program_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mini_program', function (Blueprint $table) {
            //
        });
    }
}