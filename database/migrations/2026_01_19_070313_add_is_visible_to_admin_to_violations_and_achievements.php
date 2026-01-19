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
            $table->boolean('is_visible_to_admin')->default(true)->after('status');
        });
        
        Schema::table('achievements', function (Blueprint $table) {
            $table->boolean('is_visible_to_admin')->default(true)->after('point');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('violations', function (Blueprint $table) {
            $table->dropColumn('is_visible_to_admin');
        });
        
        Schema::table('achievements', function (Blueprint $table) {
            $table->dropColumn('is_visible_to_admin');
        });
    }
};
