<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- AÑADE ESTA LÍNEA
use App\Models\User; // Asegúrate de tener el import arriba

class PerfilController extends Controller
{
    //
    public function editarAvatar()
    {
        // Simplemente devolvemos la vista que crearemos en el paso 3
        return view('perfil.editar-avatar');
    }

    public function actualizarAvatar(Request $request)
    {
        $user = Auth::user();

        // Validamos que lleguen los datos
        $request->validate([
            'avatar_base' => 'required',
            'avatar_boca' => 'required',
            'avatar_ojos' => 'required',
            'avatar_complemento' => 'required',
        ]);

        // Actualizamos al usuario
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
        // Cambiamos min:3 por min:1
        $request->validate([
            'name' => 'required|string|max:255|min:1',
        ]);

        $user = \App\Models\User::find(auth()->id());
        $user->name = $request->input('name');
        $user->save();

        // Importante: Limpiamos la caché de la sesión para que el nombre cambie al instante
        auth()->setUser($user);

        return back()->with('success', '¡Nombre actualizado, patata corta! 🥔✨');
    }

    public function index() // Asegúrate de que tu ruta en web.php apunte a 'index'
    {
        $user = auth()->user();

        // 1. Género favorito (mantenlo en null hasta que tengas la tabla de libros lista)
        $generoFavorito = null;

        // 2. Tiempo de estudio: Forzamos la consulta a la tabla correcta
        // Usamos el ID del usuario logueado para sumar sus segundos
        $segundosTotales = \App\Models\SesionEstudio::where('user_id', $user->id)
            ->sum('segundos') ?? 0;

        // Convertimos a minutos (ej: 180s / 60 = 3)
        $minutosTotales = floor($segundosTotales / 60);

        // 3. Enviamos todo a la vista 'perfil'
        return view('perfil', [
            'user' => $user,
            'generoFavorito' => $generoFavorito,
            'minutosTotales' => $minutosTotales
        ]);
    }




    public function verEstanteriaAmigo($id)
    {
        // 1. Buscamos al amigo
        $amigo = User::findOrFail($id);

        // 2. IMPORTANTE: Usamos "libros" porque así se llama en tu modelo User.php
        $books = $amigo->libros;

        // 3. Pasamos los datos a la vista
        return view('amigos.estanteria-amigo', compact('amigo', 'books'));
    }
}
