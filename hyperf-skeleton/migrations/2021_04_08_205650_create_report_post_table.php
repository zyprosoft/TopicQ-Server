<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateReportPostTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('report_post', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('post_id')->comment('举报的帖子ID');
            $table->bigInteger('owner_id')->comment('谁举报的');
            $table->text('content')->comment('举报内容');
            
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
        Schema::dropIfExists('report_post');
    }
}
