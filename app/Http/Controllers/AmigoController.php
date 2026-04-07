<?php

namespace App\Http\Controllers;

use App\Models\Amigo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AmigoController extends Controller
{
    // 1. ENVIAR SOLICITUD
    public function enviarSolicitud($amigoId)
    {
        $usuario = Auth::user();

        // Evitar agregarse a uno mismo
        if ($usuario->id == $amigoId) {
            return back()->with('error', '¡No puedes ser tu propia patata amiga!');
        }

        // Crear la conexión en el "puente"
        Amigo::create([
            'usuario_id' => $usuario->id,
            'amigo_id' => $amigoId,
            'estado' => 'pendiente'
        ]);

        return back()->with('success', 'Solicitud enviada. ¡Esperando respuesta!');
    }

    // 2. ACEPTAR SOLICITUD
    public function aceptarSolicitud($solicitudId)
    {
        $solicitud = Amigo::findOrFail($solicitudId);

        // Cambiamos el estado de pendiente a aceptado
        $solicitud->update(['estado' => 'aceptado']);

        return back()->with('success', '¡Ahora sois patatas amigas!');
    }

    // 3. ELIMINAR AMIGO (Dinamitar el puente)
    public function eliminarAmigo($amigoId)
    {
        $usuarioId = Auth::id();

        // Buscamos la fila de amistad sea quien sea el que la empezó
        Amigo::where(function ($query) use ($usuarioId, $amigoId) {
            $query->where('usuario_id', $usuarioId)->where('amigo_id', $amigoId);
        })->orWhere(function ($query) use ($usuarioId, $amigoId) {
            $query->where('usuario_id', $amigoId)->where('amigo_id', $usuarioId);
        })->delete();

        return back()->with('success', 'Amistad eliminada correctamente.');
    }

    public function index()
    {
        // 1. Cogemos todos los usuarios de la base de datos
        // 2. Quitamos a la patata que está logueada (tú) para no agregarte a ti misma
        $usuarios = User::where('id', '!=', auth()->id())->get();

        // 3. Enviamos esa lista a la vista 'usuarios.blade.php'
        return view('usuarios', compact('usuarios'));
    }
}
