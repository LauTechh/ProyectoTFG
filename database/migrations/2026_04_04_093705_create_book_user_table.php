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
        Schema::create('book_user', function (Blueprint $table) {
            $table->id();

            // 1. Relación con el Usuario (quién guarda el libro)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 2. Relación con el Libro (qué libro es)
            $table->foreignId('book_id')->constrained()->onDelete('cascade');

            // 3. El estado de lectura (con tus 3 opciones)
            $table->enum('estado', ['por_leer', 'leyendo', 'leido'])->default('por_leer');

            // 4. Tu puntuación de 1 a 5 (Tus patatas)
            $table->integer('puntuacion')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_user');
    }
};
