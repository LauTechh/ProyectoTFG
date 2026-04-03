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
        Schema::table('books', function (Blueprint $table) {
            // Esto crea la columna 'user_id' y la conecta con la tabla de usuarios
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Primero quitamos la relación (la clave foránea)
            $table->dropForeign(['user_id']);
            // Luego borramos la columna físicamente
            $table->dropColumn('user_id');
            //
        });
    }
};
