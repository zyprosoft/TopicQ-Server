<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterPostAddIgnoreRecommend extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('post', function (Blueprint $table) {
            //
            $table->tinyInteger('ignore_machine_recommend')->default(0)->comment('忽略系统推荐计算权重');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post', function (Blueprint $table) {
            //
            $table->dropColumn('ignore_machine_recommend');
        });
    }
}
