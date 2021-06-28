<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterTopicAddCircleInfo extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('topic', function (Blueprint $table) {
            //
            $table->bigInteger('circle_id')->default(0)->comment('归属于哪个圈子');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('topic', function (Blueprint $table) {
            //
            $table->dropColumn('circle_id');
        });
    }
}
