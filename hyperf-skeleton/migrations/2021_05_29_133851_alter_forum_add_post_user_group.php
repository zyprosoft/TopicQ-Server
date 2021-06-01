<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterForumAddPostUserGroup extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('forum', function (Blueprint $table) {
            //
            $table->string('can_post_user_group',500)->nullable()->comment('允许发帖的用户分组,为空的时候，所有用户均可发帖');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum', function (Blueprint $table) {
            //
            $table->dropColumn('can_post_user_group');
        });
    }
}
