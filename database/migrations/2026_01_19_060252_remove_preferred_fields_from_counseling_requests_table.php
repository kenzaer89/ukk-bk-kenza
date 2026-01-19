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
            $table->dropColumn(['preferred_date', 'preferred_start_time', 'preferred_end_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('counseling_requests', function (Blueprint $table) {
            $table->date('preferred_date')->nullable();
            $table->time('preferred_start_time')->nullable();
            $table->time('preferred_end_time')->nullable();
        });
    }
};
