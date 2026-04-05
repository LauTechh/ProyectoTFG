<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- AÑADE ESTA LÍNEA

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
}
