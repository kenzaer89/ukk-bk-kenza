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
       Schema::create('session_topic', function (Blueprint $table) {
        $table->foreignId('session_id')->constrained('counseling_sessions')->cascadeOnDelete();
        $table->foreignId('topic_id')->constrained('topics')->cascadeOnDelete();
        $table->primary(['session_id','topic_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_topic');
    }
};
