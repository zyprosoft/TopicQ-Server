<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterUserUpdateAddTextAudit extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_update', function (Blueprint $table) {
            //
            $table->tinyInteger('nickname_audit')->default(0)->comment('0待审核1审核通过-1审核不通过');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_update', function (Blueprint $table) {
            //
            $table->removeColumn('nickname_audit');
        });
    }
}
