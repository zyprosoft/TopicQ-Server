<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterUserAddAvatarUserId extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user', function (Blueprint $table) {
            //
            $table->bigInteger('avatar_user_id')->default(0)->comment('化身ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user', function (Blueprint $table) {
            //
            $table->removeColumn('avatar_user_id');
        });
    }
}
