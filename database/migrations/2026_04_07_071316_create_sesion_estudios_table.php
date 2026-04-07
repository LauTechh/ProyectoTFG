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
        Schema::create('sesiones_estudio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // La patata que estudia
            $table->string('sala'); // Ejemplo: 'despacho-rosa', 'biblioteca'
            $table->integer('segundos'); // El tiempo total que estuvo concentrada
            $table->timestamp('fecha_inicio')->nullable(); // Por si quieres saber cuándo empezó
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesion_estudios');
    }
};
