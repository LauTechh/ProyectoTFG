<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    // 1. Añadimos 'user_id' a la lista de permitidos
    protected $fillable = [
        'title',
        'author',
        'genre',
        'description',
        'cover_url',
        'user_id', // <-- ¡Súper importante!
    ];

    // 2. Definimos la relación: "Este libro pertenece a un usuario"

    public function users()
    {
        // Un libro también puede pertenecer a muchos usuarios
        return $this->belongsToMany(User::class)
            ->withPivot('estado', 'puntuacion')
            ->withTimestamps();
    }
}
