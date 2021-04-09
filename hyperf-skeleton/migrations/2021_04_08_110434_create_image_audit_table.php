<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateImageAuditTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('image_audit', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->default(0)->comment('上传者用户ID');
            $table->bigInteger('owner_id')->comment('归属ID');
            $table->tinyInteger('owner_type')->default(0)->comment('归属类型0:帖子1:评论');
            $table->string('image_id',50)->comment('图片在空间的唯一文件名');
            $table->tinyInteger('audit_status')->default(0)->comment('审核状态-1:审核不通过,0:审核中,1:审核通过');
            $table->string('audit_note',500)->nullable()->comment('审核备注内容');

            $table->index('user_id');
            $table->index(['owner_id','owner_type']);
            $table->unique('image_id');
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
        Schema::dropIfExists('image_audit');
    }
}
