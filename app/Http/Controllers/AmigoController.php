<?php

namespace App\Http\Controllers;

use App\Models\Amigo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AmigoController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();

        // 1. Obtener todas las relaciones donde participas (Aceptadas o Pendientes)
        $todasMisRelaciones = \App\Models\Amigo::where('usuario_id', $userId)
            ->orWhere('amigo_id', $userId)
            ->get();

        // 2. IDs para "Más patatas": Gente que NO eres tú y con la que NO tienes NADA
        $relacionesIds = $todasMisRelaciones->flatMap(function ($rel) {
            return [$rel->usuario_id, $rel->amigo_id];
        })->unique()->toArray();

        // Añadimos distinct() por seguridad
        $usuarios = \App\Models\User::where('id', '!=', $userId)
            ->whereNotIn('id', $relacionesIds)
            ->withCount('libros')
            ->distinct()
            ->get();

        // 3. IDs para "Mis amigos": Solo relaciones ACEPTADAS o Pendientes que TÚ enviaste
        $misRelacionesIds = $todasMisRelaciones->filter(function ($rel) use ($userId) {
            return $rel->estado === 'aceptada' || ($rel->estado === 'pendiente' && $rel->usuario_id == $userId);
        })->map(function ($rel) use ($userId) {
            return $rel->usuario_id == $userId ? $rel->amigo_id : $rel->usuario_id;
        })->unique();

        $misAmigos = \App\Models\User::whereIn('id', $misRelacionesIds)
            ->withCount('libros')
            ->distinct()
            ->get();

        // 4. Solicitudes Recibidas (Paula envía a Laura)
        $solicitudesRecibidas = \App\Models\Amigo::where('amigo_id', $userId)
            ->where('estado', 'pendiente')
            ->with('sender')
            ->get();

        $solicitudesPendientes = $solicitudesRecibidas->count();

        return view('usuarios', compact('usuarios', 'misAmigos', 'solicitudesPendientes', 'solicitudesRecibidas'));
    }

    // 1. ENVIAR SOLICITUD (Corregido el nombre de la columna)
    public function enviarSolicitud($id)
    {
        $userId = auth()->id();
        $amigoId = $id;

        if ($userId == $amigoId) {
            return back()->with('error', '¡No puedes ser tu propio amigo, patata solitaria!');
        }

        // 🔍 CORRECCIÓN: Antes buscabas por 'user_id', pero tu tabla usa 'usuario_id'
        $existe = \App\Models\Amigo::where(function ($q) use ($userId, $amigoId) {
            $q->where('usuario_id', $userId)->where('amigo_id', $amigoId);
        })->orWhere(function ($q) use ($userId, $amigoId) {
            $q->where('usuario_id', $amigoId)->where('amigo_id', $userId);
        })->first();

        if (!$existe) {
            \App\Models\Amigo::create([
                'usuario_id' => $userId,
                'amigo_id' => $amigoId,
                'estado' => 'pendiente',
            ]);
            return back()->with('success', '¡Solicitud enviada! 🥔');
        }

        return back()->with('error', 'Ya existe una relación con esta patata.');
    }

    // ... (Aceptar, Rechazar y Eliminar se mantienen igual, están bien enfocados)

    public function aceptarSolicitud($id)
    {
        $userId = auth()->id();
        $solicitud = \App\Models\Amigo::where('usuario_id', $id)
            ->where('amigo_id', $userId)
            ->where('estado', 'pendiente')
            ->first();

        if ($solicitud) {
            $solicitud->update(['estado' => 'aceptada']);
            return redirect()->route('amigos.index', ['tab' => 'mis-amigos'])
                ->with('success', '¡Nueva patata amiga añadida!');
        }
        return back()->with('error', 'No se pudo encontrar la solicitud.');
    }

    public function rechazarSolicitud($id)
    {
        $userId = auth()->id();

        // Buscamos la solicitud donde TÚ eres el receptor (amigo_id) 
        // y el otro es el emisor (usuario_id)
        $solicitud = \App\Models\Amigo::where('usuario_id', $id)
            ->where('amigo_id', $userId)
            ->where('estado', 'pendiente')
            ->first();

        if ($solicitud) {
            $solicitud->delete(); // Borramos la fila de la base de datos
            return back()->with('success', 'Solicitud rechazada. ¡Esa patata no entrará en tu huerto!');
        }

        return back()->with('error', 'No se pudo encontrar la solicitud para rechazar.');
    }

    public function eliminarAmigo($id)
    {
        $userId = auth()->id();
        $relacion = \App\Models\Amigo::where(function ($q) use ($userId, $id) {
            $q->where('usuario_id', $userId)->where('amigo_id', $id);
        })->orWhere(function ($q) use ($userId, $id) {
            $q->where('usuario_id', $id)->where('amigo_id', $userId);
        })->first();

        if ($relacion) {
            $relacion->delete();
            return back()->with('success', 'Amistad eliminada con éxito.');
        }
        return back()->with('error', 'No se pudo encontrar la relación.');
    }
}
