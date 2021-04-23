<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterCommentAddImageIdList extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('comment', function (Blueprint $table) {
            //
            $table->string('image_ids',500)->nullable()->comment('图片列表获取出来图片ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('', function (Blueprint $table) {
            //
            $table->removeColumn('image_ids');
        });
    }
}
