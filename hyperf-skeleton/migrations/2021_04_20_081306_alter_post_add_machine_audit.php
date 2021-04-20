<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterPostAddMachineAudit extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('post', function (Blueprint $table) {
            //
            $table->tinyInteger('machine_audit')->default(0)->comment('机器审核结果:0待审核-1不通过1通过2建议人工复核');
            $table->tinyInteger('manager_audit')->default(0)->comment('管理员审核结果:0待审核-1不通过1通过');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post', function (Blueprint $table) {
            //
            $table->removeColumn('machine_audit');
            $table->removeColumn('manager_audit');
        });
    }
}
