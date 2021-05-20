<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAppSettingTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app_setting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('app_name',24)->nullable()->comment('名称');
            $table->text('app_introduce')->nullable()->comment('应用介绍');
            $table->string('protocol_url',500)->nullable()->comment('用户协议地址');
            $table->string('about_url',500)->nullable()->comment('关于地址');
            $table->string('app_version',24)->nullable()->comment('应用版本');
            $table->string('contact_weixin',64)->nullable()->comment('联系微信');
            $table->tinyInteger('custom_no_more')->default(0)->comment('自定义没有更多');
            $table->string('company',64)->nullable()->comment('公司名');
            $table->string('api_version',24)->default('1.0.0')->comment('后端接口版本');
            $table->string('theme_color')->nullable()->comment('主题颜色');
            $table->tinyInteger('custom_theme')->default(0)->comment('是否自定义主题颜色');
            $table->tinyInteger('theme_gradual')->default(0)->comment('主题色是否渐变');
            $table->tinyInteger('subscribe_open')->default(0)->comment('是否打开付费订阅0不打开1打开默认不打开');
            $table->tinyInteger('private_message_open')->default(1)->comment('私信功能是否打开0不打开1打开');
            $table->tinyInteger('message_on_attention')->default(1)->comment('必须关注才能发消息0不需要1需要');
            $table->tinyInteger('self_mall_open')->default(0)->comment('自营店铺，默认不打开,不打开的情况下我的订单也被隐藏起来');
            $table->tinyInteger('red_bag_post')->default(0)->comment('悬赏帖是否打开');
            $table->tinyInteger('praise_cash_post')->default(0)->comment('赞赏功能是否打开');

            $table->timestamps();
            $table->softDeletes();
            $table->engine = "InnoDB";
            $table->charset = "utf8mb4";
            $table->collation = "utf8mb4_unicode_ci";
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_setting');
    }
}
