<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // Esto le dice a Laravel: "Está bien guardar datos en estas columnas"
    protected $fillable = [
        'title',
        'author',
        'genre',
        'description',
        'cover_url',
    ];
}