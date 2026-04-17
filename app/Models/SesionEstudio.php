<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SesionEstudio extends Model
{
    use HasFactory;

    protected $table = 'sesiones_estudio';

    protected $fillable = [
        'user_id',
        'sala', // Lo cambiamos aquí para que coincida con la migración
        'segundos',
        'fecha_inicio'
    ];

    // Cambiamos a true porque es mejor tener el control de cuándo se creó el registro
    public $timestamps = true;

    /**
     * Relación con el usuario: Una sesión pertenece a un usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
