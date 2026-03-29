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
        Schema::table('users', function (Blueprint $table) {
            //Añadimos 3 columnas para guardar los nombres de los archivos PNG
            $table->string('avatar_base')->nullable();
            $table->string('avatar_linea')->nullable();
            $table->string('avatar_ojos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //// Si deshacemos la migración, borramos estas columnas
            $table->dropColumn(['avatar_base', 'avatar_linea', 'avatar_ojos']);
        });
    }
};
