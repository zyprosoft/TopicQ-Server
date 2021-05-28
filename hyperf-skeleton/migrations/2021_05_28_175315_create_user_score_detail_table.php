<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserScoreDetailTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_score_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_score_detail');
    }
}
