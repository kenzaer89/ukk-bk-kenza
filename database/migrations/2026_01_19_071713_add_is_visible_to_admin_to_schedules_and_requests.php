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
        Schema::table('counseling_schedules', function (Blueprint $table) {
            $table->boolean('is_visible_to_admin')->default(true)->after('status');
        });

        Schema::table('counseling_requests', function (Blueprint $table) {
            $table->boolean('is_visible_to_admin')->default(true)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('counseling_schedules', function (Blueprint $table) {
            $table->dropColumn('is_visible_to_admin');
        });

        Schema::table('counseling_requests', function (Blueprint $table) {
            $table->dropColumn('is_visible_to_admin');
        });
    }
};
