<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amigo extends Model
{
    use HasFactory;

    // 1. Le decimos que la tabla se llama 'amigos' (en español)
    protected $table = 'amigos';

    // 2. Los campos que podemos rellenar
    protected $fillable = [
        'usuario_id',
        'amigo_id',
        'estado'
    ];

    // 3. Relación: ¿Quién envió la invitación?
    public function remitente()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // 4. Relación: ¿Quién recibió la invitación?
    public function destinatario()
    {
        return $this->belongsTo(User::class, 'amigo_id');
    }
    
    public function sender()
    {
        // El 'usuario_id' es el que envía la solicitud
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
