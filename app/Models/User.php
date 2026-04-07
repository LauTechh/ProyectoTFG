<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // <-- CAMBIO: Usamos BelongsToMany para estanterías

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_base',
        'avatar_boca',
        'avatar_ojos',
        'avatar_complemento'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación con los libros (La Estantería)
     */
    public function libros(): BelongsToMany
    {
        return $this->belongsToMany(Libro::class, 'book_user', 'user_id', 'book_id')
            ->withPivot('estado', 'puntuacion')
            ->withTimestamps();
    }



    /**
     * Amigos que YO he agregado (Yo soy el remitente)
     */
    public function amigosEnviados()
    {
        return $this->belongsToMany(User::class, 'amigos', 'usuario_id', 'amigo_id')
            ->withPivot('estado')
            ->withTimestamps();
    }

    /**
     * Amigos que ME han agregado (Yo soy el destinatario)
     */
    public function amigosRecibidos()
    {
        return $this->belongsToMany(User::class, 'amigos', 'amigo_id', 'usuario_id')
            ->withPivot('estado')
            ->withTimestamps();
    }

    /**
     * Función mágica para obtener TODOS los amigos aceptados
     */
    public function misAmigos()
    {
        // Esto busca en ambas listas solo los que tienen estado 'aceptado'
        $enviados = $this->amigosEnviados()->wherePivot('estado', 'aceptado')->get();
        $recibidos = $this->amigosRecibidos()->wherePivot('estado', 'aceptado')->get();

        return $enviados->merge($recibidos);
    }
}
