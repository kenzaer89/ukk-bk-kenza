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
        Schema::table('counseling_requests', function (Blueprint $table) {
            $table->string('teacher_name')->nullable()->after('teacher_id');
        });

        Schema::table('counseling_schedules', function (Blueprint $table) {
            $table->string('teacher_name')->nullable()->after('teacher_id');
            // Make teacher_id nullable if it wasn't already (it was constrained but maybe not nullable)
            $table->unsignedBigInteger('teacher_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('counseling_requests', function (Blueprint $table) {
            $table->dropColumn('teacher_name');
        });

        Schema::table('counseling_schedules', function (Blueprint $table) {
            $table->dropColumn('teacher_name');
            $table->unsignedBigInteger('teacher_id')->nullable(false)->change();
        });
    }
};
