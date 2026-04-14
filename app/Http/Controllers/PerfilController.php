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
        // Usamos 'libros' (la relación) y 'puntuacion' (la columna de tu DB)
        $estadisticasGeneros = $usuario->libros()
            ->select('genre', DB::raw('AVG(book_user.puntuacion) as media_puntuacion'))
            ->whereNotNull('book_user.puntuacion')
            ->where('book_user.puntuacion', '>', 0)
            ->groupBy('genre')
            ->orderBy('media_puntuacion', 'desc')
            ->get();

        // 2. Tiempo de estudio
        $segundosTotales = \App\Models\SesionEstudio::where('user_id', $usuario->id)
            ->sum('segundos') ?? 0;

        $minutosTotales = floor($segundosTotales / 60);

        // 3. Enviamos todo a la vista 'perfil'
        return view('perfil', [
            'user' => $usuario, // Mantenemos 'user' porque tu vista Blade ya lo usa así
            'estadisticasGeneros' => $estadisticasGeneros,
            'minutosTotales' => $minutosTotales
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
