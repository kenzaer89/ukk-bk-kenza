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
            // Tambah student_id
            if (!Schema::hasColumn('counseling_sessions', 'student_id')) {
                $table->foreignId('student_id')->nullable()->after('id')->constrained('users')->cascadeOnDelete();
            }
            
            // Tambah counselor_id
            if (!Schema::hasColumn('counseling_sessions', 'counselor_id')) {
                $table->foreignId('counselor_id')->nullable()->after('student_id')->constrained('users')->cascadeOnDelete();
            }
            
            // Ubah schedule_id jadi nullable
            $table->unsignedBigInteger('schedule_id')->nullable()->change();

            // Tambah session_type
            if (!Schema::hasColumn('counseling_sessions', 'session_type')) {
                $table->string('session_type')->default('individual')->after('counselor_id');
            }

            // Tambah waktu
            if (!Schema::hasColumn('counseling_sessions', 'start_time')) {
                $table->time('start_time')->nullable()->after('session_date');
            }
            if (!Schema::hasColumn('counseling_sessions', 'end_time')) {
                $table->time('end_time')->nullable()->after('start_time');
            }

            // Tambah lokasi
            if (!Schema::hasColumn('counseling_sessions', 'location')) {
                $table->string('location')->nullable()->after('end_time');
            }

            // Tambah notes (beda dengan teacher_notes yang sudah ada)
            if (!Schema::hasColumn('counseling_sessions', 'notes')) {
                $table->text('notes')->nullable()->after('location');
            }

            // Tambah status
            if (!Schema::hasColumn('counseling_sessions', 'status')) {
                $table->string('status')->default('completed')->after('notes');
            }

            // Tambah follow_up_required
            if (!Schema::hasColumn('counseling_sessions', 'follow_up_required')) {
                $table->boolean('follow_up_required')->default(false)->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('counseling_sessions', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['counselor_id']);
            $table->dropColumn([
                'student_id', 
                'counselor_id', 
                'session_type', 
                'start_time', 
                'end_time', 
                'location', 
                'notes', 
                'status', 
                'follow_up_required'
            ]);
            
            // Revert schedule_id to not null (might fail if there are nulls)
            // $table->unsignedBigInteger('schedule_id')->nullable(false)->change();
        });
    }
};
