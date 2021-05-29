<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterForumAddAccessUserGroup extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('forum', function (Blueprint $table) {
            //
            $table->string('can_access_user_group')->nullable()->comment('可以访问版块的用户组');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum', function (Blueprint $table) {
            //
            $table->dropColumn('can_access_user_group');
        });
    }
}
