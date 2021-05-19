<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterTopicAddSortIndex extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('topic', function (Blueprint $table) {
            //
            $table->bigInteger('recommend_weight')->default(0)->comment('推荐权重');
            $table->tinyInteger('sort_index')->default(0)->comment('置顶');
            $table->string('tag',4)->nullable()->comment('自定义标签');
            $table->tinyInteger('audit_status')->default(0)->comment('0:待审核1通过-1不通过审核状态，话题必须要管理员审核通过');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('topic', function (Blueprint $table) {
            //
            $table->dropColumn('recommend_weight');
            $table->dropColumn('sort_index');
            $table->dropColumn('tag');
//            $table->dropColumn('audit_status');
        });
    }
}
