<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterUserAttentionOtherAddReadStatus extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_attention_other', function (Blueprint $table) {
            //
            $table->tinyInteger('is_read')->default(0)->comment('被关注者是否已读');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_attention_other', function (Blueprint $table) {
            //
            $table->dropColumn('is_read');
        });
    }
}
