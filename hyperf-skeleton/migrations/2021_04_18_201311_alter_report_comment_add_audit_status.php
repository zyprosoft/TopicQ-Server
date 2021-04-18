<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class AlterReportCommentAddAuditStatus extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('report_comment', function (Blueprint $table) {
            //
            $table->tinyInteger('audit_status')->default(0)->comment('0审核中1:审核通过-1:审核不通过');
            $table->string('audit_note')->nullable()->comment('审核备注');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_comment', function (Blueprint $table) {
            //
            $table->removeColumn('audit_status');
            $table->removeColumn('audit_note');
        });
    }
}
