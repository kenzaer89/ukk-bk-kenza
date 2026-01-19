<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('points')->nullable()->default(null)->change();
        });

        // Set points to NULL for all non-student roles
        DB::table('users')
            ->where('role', '!=', 'student')
            ->update(['points' => null]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('points')->nullable(false)->default(100)->change();
        });
        
        // Restore default 100 for non-students (optional, but consistent with down)
        DB::table('users')
            ->where('role', '!=', 'student')
            ->update(['points' => 100]);
    }
};
