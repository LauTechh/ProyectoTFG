<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Libro extends Model
{
    // ESTA ES LA LÍNEA MÁGICA:
    protected $table = 'books';

    protected $fillable = ['title', 'author', 'genre', 'cover_url', 'user_id'];
    
    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'book_user', 'book_id', 'user_id')
            ->withPivot('estado', 'puntuacion')
            ->withTimestamps();
    }
}
