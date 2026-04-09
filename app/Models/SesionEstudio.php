<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesionEstudio extends Model
{
    use HasFactory;

    protected $table = 'sesiones_estudio';

    protected $fillable = [
        'user_id',
        'sala',
        'segundos',
        'fecha_inicio'
    ];

    // 💡 SI TU TABLA NO TIENE LAS COLUMNAS created_at y updated_at, 
    // Laravel dará error 500 a menos que pongas esta línea:
    public $timestamps = false;
}
