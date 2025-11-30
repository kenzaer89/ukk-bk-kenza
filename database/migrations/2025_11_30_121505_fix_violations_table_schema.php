<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('violations', function (Blueprint $table) {
            $table->renameColumn('notes', 'description');
            $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete()->after('rule_id');
            $table->string('status')->default('pending')->after('description'); // pending, resolved, escalated
            $table->text('follow_up_action')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('violations', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn(['teacher_id', 'status', 'follow_up_action']);
            $table->renameColumn('description', 'notes');
        });
    }
};
