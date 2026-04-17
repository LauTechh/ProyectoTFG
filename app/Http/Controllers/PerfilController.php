<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PerfilController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();

        // 1. CÁLCULO DEL GÉNERO MÁS VALORADO
        $estadisticasGeneros = $usuario->libros()
            ->select('books.genre', \Illuminate\Support\Facades\DB::raw('AVG(book_user.puntuacion) as media_puntuacion'))
            ->whereNotNull('book_user.puntuacion')
            ->where('book_user.puntuacion', '>', 0)
            ->groupBy('books.genre')
            ->orderBy('media_puntuacion', 'desc')
            ->get();

        // 2. Tiempo de estudio (DESGLOSADO POR SALA)
        // 🎯 Añadimos esta parte para el desglose en el perfil
        $tiemposPorSala = \App\Models\SesionEstudio::where('user_id', $usuario->id)
            ->select('sala', \Illuminate\Support\Facades\DB::raw('SUM(segundos) as total_segundos'))
            ->groupBy('sala')
            ->get();

        // Calculamos el total general (lo que ya tenías)
        $segundosTotales = $tiemposPorSala->sum('total_segundos') ?? 0;
        $minutosTotales = floor($segundosTotales / 60);

        // 3. Enviamos todo a la vista 'perfil'
        return view('perfil', [
            'user' => $usuario,
            'estadisticasGeneros' => $estadisticasGeneros,
            'minutosTotales' => $minutosTotales,
            'tiemposPorSala' => $tiemposPorSala // 👈 ¡ESTA ES LA CLAVE!
        ]);
    }

    public function editarAvatar()
    {
        return view('perfil.editar-avatar');
    }

    public function actualizarAvatar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'avatar_base' => 'required',
            'avatar_boca' => 'required',
            'avatar_ojos' => 'required',
            'avatar_complemento' => 'required',
        ]);

        $user->update([
            'avatar_base' => $request->avatar_base,
            'avatar_boca' => $request->avatar_boca,
            'avatar_ojos' => $request->avatar_ojos,
            'avatar_complemento' => $request->avatar_complemento,
        ]);

        return redirect()->route('perfil')->with('success', '¡Avatar actualizado! 🥔✨');
    }

    public function actualizarNombre(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:1',
        ]);

        $user = User::find(auth()->id());
        $user->name = $request->input('name');
        $user->save();

        auth()->setUser($user);

        return back()->with('success', '¡Nombre actualizado! 🥔✨');
    }

    public function visitarPerfil($id)
    {
        $amigo = User::findOrFail($id);

        // 🎯 Aquí ya lo tenías bien como "libros"
        $books = $amigo->libros;

        return view('amigos.perfil-amigo', compact('amigo', 'books'));
    }
}
