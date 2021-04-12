<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->string('username',20)->nullable()->comment('用户名');
            $table->string('password',500)->nullable()->comment('密码');
            $table->tinyInteger('role_id')->default(0)->comment('用户角色');
            $table->string('mobile', 11)->nullable()->comment('手机');
            $table->string('nickname',20)->nullable()->comment('昵称');
            $table->string('address',128)->nullable()->comment('收货地址');
            $table->string('avatar',500)->nullable()->comment('头像');
            $table->string('wx_openid',128)->comment('微信openid');
            $table->string('wx_token',500)->comment('微信登陆token');
            $table->tinyInteger('status')->default(0)->comment('设置用户的一些处理状态,0:正常');
            $table->string('block_reason',128)->nullable()->comment('拉黑原因');
            $table->timestamp('last_login', 0)->nullable()->comment('上次登陆时间');
            $table->string('location',128)->nullable()->comment('位置');
            $table->tinyInteger('sex')->default(0)->comment('0:男1:女');
            $table->tinyInteger('login_type')->default(0)->comment('登陆类型;0:小程序1:web管理端');
            $table->tinyInteger('wx_gender')->default(1)->comment('微信性别1:男');
            $table->string('wx_province',30)->nullable()->comment('微信省份');
            $table->string('wx_city',30)->nullable()->comment('微信城市');
            $table->string('wx_country',30)->nullable()->comment('微信国家');
            $table->timestamp('wx_token_expire', 0)->nullable()->comment('微信token失效绝对时间');
            $table->string('token', 500)->nullable()->comment('登陆的Token');
            $table->timestamp('token_expire', 0)->nullable()->comment('登陆Token的过期时间');
            $table->integer('unread_reply_count')->default(0)->comment('未读回复数量');
            $table->integer('unread_comment_count')->default(0)->comment('未读评论数量');

            $table->index('status');
            $table->unique('wx_openid');
            $table->unique('username');
            $table->softDeletes();
            $table->timestamps();
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
        Schema::dropIfExists('user');
    }
}
