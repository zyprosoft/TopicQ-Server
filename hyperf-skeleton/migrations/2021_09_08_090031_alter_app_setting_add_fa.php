<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterAppSettingAddFa extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('official_account_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('open_id',128)->comment('公众号openID');
            $table->string('union_id',128)->nullable()->comment('unionID');
            $table->tinyInteger('is_subscribe')->default(0)->comment('是否关注公众号');
            $table->timestamp('attention_time')->nullable()->comment('关注时间');
            $table->string('attention_scene',64)->nullable()->comment('关注时间');

            $table->unique('open_id');
            $table->unique('union_id');
            $table->timestamps();
            $table->engine = "InnoDB";
            $table->charset = "utf8mb4";
            $table->collation = "utf8mb4_unicode_ci";
        });

        Schema::table('app_setting', function (Blueprint $table) {
            //
            $table->string('attention_fa_url',500)->nullable()->comment('关注公众号的引导链接');
            $table->tinyInteger('enable_attention_fa')->default(0)->comment('是否开启引导关注公众号');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('official_account_user');
        Schema::table('app_setting', function (Blueprint $table) {
            //
            $table->dropColumn('attention_fa_url');
            $table->dropColumn('enable_attention_fa');
        });
    }
}
