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
        Schema::create('violations', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke tabel users (siswa)
            $table->foreignId('student_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            
            // Foreign key ke tabel rules
            $table->foreignId('rule_id')
                  ->constrained('rules')
                  ->restrictOnDelete();
            
            $table->date('violation_date');
            $table->text('notes')->nullable();
            
            // Timestamps otomatis (created_at & updated_at)
            $table->timestamps();

            // Index untuk performa query
            $table->index('student_id', 'idx_violations_student_id');
            $table->index('rule_id', 'idx_violations_rule_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};
