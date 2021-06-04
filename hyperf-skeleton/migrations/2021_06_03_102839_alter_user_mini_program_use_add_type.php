<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterUserMiniProgramUseAddType extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_mini_program_use', function (Blueprint $table) {
            //
            $table->string('type',12)->default('weixin')->comment('小程序类型');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_mini_program_use', function (Blueprint $table) {
            //
            $table->dropColumn('type');
        });
    }
}
