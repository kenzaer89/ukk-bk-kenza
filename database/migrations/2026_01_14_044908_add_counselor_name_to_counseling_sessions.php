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
        Schema::table('counseling_sessions', function (Blueprint $table) {
            $table->string('counselor_name')->nullable()->after('counselor_id');
            $table->unsignedBigInteger('counselor_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('counseling_sessions', function (Blueprint $table) {
            $table->dropColumn('counselor_name');
            $table->unsignedBigInteger('counselor_id')->nullable(false)->change();
        });
    }
};
