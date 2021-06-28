<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateCircleTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('circle', function (Blueprint $table) {
            $table->bigIncrements('circle_id');
            $table->string('name',10)->comment('圈名字');
            $table->bigInteger('owner_id')->comment('圈主');
            $table->string('avatar',256)->comment('圈头像');
            $table->string('background',256)->comment('圈背景');
            $table->bigInteger('member_count')->default(0)->comment('成员数量');
            $table->bigInteger('post_count')->default(0)->comment('帖子数量');
            $table->tinyInteger('is_open')->default(1)->comment('是否公开的圈子');
            $table->string('password',500)->nullable()->comment('圈密码');
            $table->tinyInteger('use_password')->default(0)->comment('是不是使用密码进入');
            $table->dateTime('last_active_time')->nullable()->comment('最后活跃时间');
            $table->integer('category_id')->comment('圈分类');
            $table->string('introduce',500)->comment('圈介绍');
            $table->string('qq',30)->nullable()->comment('QQ群');
            $table->string('wechat',128)->nullable()->comment('微信群');
            $table->tinyInteger('audit_status')->default(0)->comment('0待审核，1审核通过，-1审核不通过');
            $table->bigInteger('topic_count')->default(0)->comment('圈话题数量');
            $table->bigInteger('recommend_weight')->default(0)->comment('推荐权重');
            $table->string('tags',256)->nullable()->comment('标签');
            $table->tinyInteger('is_hot')->default(0)->comment('是否热门圈子');
            $table->tinyInteger('is_recommend')->default(0)->comment('是否被推荐的圈子');
            $table->integer('open_score')->default(0)->comment('使用多少积分加入0的时候无限制');

            $table->unique('name');
            $table->index('owner_id');
            $table->index('category_id');
            $table->index('is_open');
            $table->index('audit_status');
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
        Schema::dropIfExists('circle');
    }
}
