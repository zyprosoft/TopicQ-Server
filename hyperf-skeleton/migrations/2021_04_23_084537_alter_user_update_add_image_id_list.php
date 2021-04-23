<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterUserUpdateAddImageIdList extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_update', function (Blueprint $table) {
            //
            $table->string('image_ids',130)->nullable()->comment('图片列表获取出来图片ID');
            $table->index('image_ids');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_update', function (Blueprint $table) {
            //
            $table->removeColumn('image_ids');
        });
    }
}
