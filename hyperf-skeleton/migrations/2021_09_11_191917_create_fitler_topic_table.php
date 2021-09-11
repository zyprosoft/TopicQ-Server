<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateFitlerTopicTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('filter_topic', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ref_id',32)->comment('引用ID');
            $table->timestamps();
            $table->unique('ref_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filter_topic');
    }
}
