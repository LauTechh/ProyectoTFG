<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesionEstudio extends Model
{
    use HasFactory;

    // 1. Le decimos el nombre EXACTO que hemos visto en el db:show
    protected $table = 'sesiones_estudio';

    // 2. Permisos para guardar datos
    protected $fillable = [
        'user_id',
        'sala',
        'segundos',
        'fecha_inicio'
    ];
}
