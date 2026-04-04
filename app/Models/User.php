<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Añadimos esto para las relaciones

#[Fillable(['name', 'email', 'password', 'avatar_base', 'avatar_boca', 'avatar_ojos', 'avatar_complemento'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    public function books()
    {
        // Esto le dice a Laravel: "Un usuario tiene muchos libros a través de la tabla book_user"
        // withPivot nos permite traer también el estado y la puntuación (las patatas)
        return $this->belongsToMany(Book::class)
            ->withPivot('estado', 'puntuacion')
            ->withTimestamps();
    }
} // <-- Solo UNA llave aquí al final