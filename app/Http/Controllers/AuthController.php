<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Esta función se encarga de intentar el inicio de sesión
    public function login(Request $request)
    {
        // 1. Cogemos solo el email y la contraseña del formulario
        $credenciales = $request->only('email', 'password');

        // 2. Intentamos entrar. Laravel comprueba si los datos coinciden con la BD
        if (Auth::attempt($credenciales)) {
            // Si es correcto, entramos a la página principal
            return redirect()->intended('/');
        }

        // 3. Si falla, volvemos atrás con un mensaje de error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    public function registrar(Request $request)
    {
        // 1. Creamos el usuario en la base de datos
        $usuario = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // ¡Esto encripta la contraseña por seguridad!
        ]);

        // 2. Lo logueamos automáticamente
        Auth::login($usuario);

        // 3. Lo mandamos a la página principal
        return redirect('/');
    }
}
