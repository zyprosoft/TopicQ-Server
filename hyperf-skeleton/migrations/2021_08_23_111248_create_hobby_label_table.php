<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateHobbyLabelTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hobby_label', function (Blueprint $table) {
            $table->bigIncrements('hobby_id');
            $table->bigInteger('category_id')->comment('所属分类');
            $table->string('title',12)->comment('内容');

            $table->unique(['category_id','title']);
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
        Schema::dropIfExists('hobby_label');
    }
}
