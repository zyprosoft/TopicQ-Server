<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterUserAddUnionId extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user', function (Blueprint $table) {
            //
            $table->string('wx_union_id',128)->nullable()->comment('微信的unionID');
            $table->string('wx_fa_open_id',128)->nullable()->comment('公众号openID');
            $table->tinyInteger('wx_fa_is_subscribe')->nullable()->comment('公众号是否关注');
            $table->timestamp('wx_fa_subscribe_time')->nullable()->comment('订阅时间');
            $table->string('wx_fa_subscribe_scene')->nullable()->comment('订阅场景');
            $table->unique('wx_union_id');
            $table->unique('wx_fa_open_id');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            //
            $table->dropColumn('wx_union_id');
            $table->dropColumn('wx_fa_open_id');
            $table->dropColumn('wx_fa_is_subscribe');
            $table->dropColumn('wx_fa_subscribe_time');
            $table->dropColumn('wx_fa_subscribe_scene');
        });
    }
}
