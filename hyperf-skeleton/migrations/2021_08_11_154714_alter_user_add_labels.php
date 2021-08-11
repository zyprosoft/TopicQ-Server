<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterUserAddLabels extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user', function (Blueprint $table) {
            //
            $table->text('hobby_label')->nullable()->comment('兴趣标签');
            $table->integer('day_sign_count')->default(0)->comment('连续签到');
            $table->integer('day_sign_total')->default(0)->comment('总签到数');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            //
            $table->dropColumn('hobby_label');
            $table->dropColumn('day_sign_count');
            $table->dropColumn('day_sign_total');
        });
    }
}
