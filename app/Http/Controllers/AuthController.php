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
        // En lugar de crear al usuario YA, guardamos sus datos en la "mochila" (sesión)
        // Esto permite que los datos viajen de una página a otra sin perderse
        session(['datos_registro' => $request->only('name', 'email', 'password')]);

        // Mandamos al usuario a la pantalla de la patata
        return redirect('/registro/paso2');
    }

    public function finalizarRegistro(Request $request)
    {
        // Recuperamos los datos que guardamos antes en la "mochila"
        $datos = session('datos_registro');

        // Ahora SÍ creamos el usuario con TODO: datos básicos + piezas de la patata
        $usuario = User::create([
            'name' => $datos['name'],
            'email' => $datos['email'],
            'password' => Hash::make($datos['password']),
            'avatar_base' => $request->avatar_base,   // El PNG de la base
            'avatar_linea' => $request->avatar_linea, // El PNG de la línea
            'avatar_ojos' => $request->avatar_ojos,   // El PNG de los ojos
        ]);

        // Lo logueamos y lo mandamos al inicio
        Auth::login($usuario);
        return redirect()->to('/menu');
    }
}
