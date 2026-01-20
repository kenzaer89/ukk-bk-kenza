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
        Schema::create('rules', function (Blueprint $table) {
            $table->id();
            $table->string('name',191);
            $table->text('description')->nullable();
            $table->string('category', 100)->nullable();
            $table->boolean('is_custom')->default(false);
            $table->integer('points')->default(0);
            
            // GANTI BARIS LAMA INI:
            // $table->timestamp('created_at')->useCurrent(); 

            // DENGAN BARIS STANDAR INI:
            $table->timestamps(); // Ini membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rules');
    }
};