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

        // 1. Obtener todas las relaciones donde participas
        $todasMisRelaciones = \App\Models\Amigo::where('usuario_id', $userId)
            ->orWhere('amigo_id', $userId)
            ->get();

        // 2. IDs para "Más patatas" (Gente con la que NO tienes absolutamente nada)
        $relacionesIds = $todasMisRelaciones->flatMap(function ($rel) {
            return [$rel->usuario_id, $rel->amigo_id];
        })->unique()->toArray();

        $usuarios = \App\Models\User::where('id', '!=', $userId)
            ->whereNotIn('id', $relacionesIds)
            ->withCount('libros') // Optimización para el badge de libros
            ->get();

        // 3. IDs para "Mis amigos" (Filtrado Inteligente)
        $misRelacionesIds = $todasMisRelaciones->filter(function ($rel) use ($userId) {
            // Aceptamos la relación si:
            // - El estado es 'aceptada' (da igual quién envió)
            // - O el estado es 'pendiente' PERO la enviaste TÚ (usuario_id es tu ID)
            return $rel->estado === 'aceptada' || ($rel->estado === 'pendiente' && $rel->usuario_id == $userId);
        })->map(function ($rel) use ($userId) {
            return $rel->usuario_id == $userId ? $rel->amigo_id : $rel->usuario_id;
        })->unique();

        $misAmigos = \App\Models\User::whereIn('id', $misRelacionesIds)
            ->withCount('libros')
            ->get();

        // 4. Contador para la burbuja de la pestaña de Solicitudes
        // CONTADOR DE SOLICITUDES: Solo las que TÚ has recibido y están esperando
        $solicitudesPendientes = \App\Models\Amigo::where('amigo_id', $userId)
            ->where('estado', 'pendiente')
            ->count();

        return view('usuarios', compact('usuarios', 'misAmigos', 'solicitudesPendientes'));
    }


    // 1. ENVIAR SOLICITUD
    public function enviarSolicitud($id)
    {
        $userId = auth()->id(); // Persona A (tú)
        $amigoId = $id;         // Persona B (la de la tarjeta)

        // 1. Evitar agregarse a uno mismo
        if ($userId == $amigoId) {
            return back()->with('error', '¡No puedes ser tu propio amigo, patata solitaria!');
        }

        // 2. Comprobar si ya existe una relación (para no duplicar)
        $existe = \App\Models\Amigo::where('user_id', $userId)
            ->where('amigo_id', $amigoId)
            ->first();

        if (!$existe) {
            \App\Models\Amigo::create([
                'usuario_id' => $userId,
                'amigo_id' => $amigoId,
                'estado' => 'pendiente',
            ]);
        }

        return back()->with('success', '¡Solicitud enviada! Esperando a que acepte... 🥔');
    }

    // 2. ACEPTAR SOLICITUD
    public function aceptarSolicitud($id)
    {
        $userId = auth()->id();

        // Buscamos la solicitud donde TÚ eres el receptor (amigo_id)
        $solicitud = \App\Models\Amigo::where('usuario_id', $id)
            ->where('amigo_id', $userId)
            ->where('estado', 'pendiente')
            ->first();

        if ($solicitud) {
            $solicitud->update(['estado' => 'aceptada']);

            // Redirigimos a la pestaña de mis-amigos para que vea que ya está ahí
            return redirect()->route('amigos.index', ['tab' => 'mis-amigos'])
                ->with('success', '¡Nueva patata amiga añadida!');
        }

        return back()->with('error', 'No se pudo encontrar la solicitud.');
    }


    public function rechazarSolicitud($id)
    {
        $userId = auth()->id();

        $solicitud = \App\Models\Amigo::where('usuario_id', $id)
            ->where('amigo_id', $userId)
            ->where('estado', 'pendiente')
            ->first();

        if ($solicitud) {
            $solicitud->delete(); // Al borrarla, "vuelve a ser un desconocido"

            // Redirigimos a la pestaña de buscar (o por defecto)
            return redirect()->route('amigos.index', ['tab' => 'buscar'])
                ->with('success', 'Solicitud rechazada. La patata ha vuelto al campo.');
        }

        return back()->with('error', 'No se pudo encontrar la solicitud.');
    }

    // 3. ELIMINAR AMIGO (Dinamitar el puente)
    public function eliminarAmigo($id)
    {
        $userId = auth()->id();

        // Buscamos la relación de amistad (ya sea que tú la enviaras o la recibieras)
        $relacion = \App\Models\Amigo::where(function ($q) use ($userId, $id) {
            $q->where('usuario_id', $userId)->where('amigo_id', $id);
        })
            ->orWhere(function ($q) use ($userId, $id) {
                $q->where('usuario_id', $id)->where('amigo_id', $userId);
            })
            ->first();

        if ($relacion) {
            $relacion->delete();
            return back()->with('success', 'Amistad eliminada con éxito.');
        }

        return back()->with('error', 'No se pudo encontrar la relación.');
    }
}
