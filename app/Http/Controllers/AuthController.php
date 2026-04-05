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
        // 1. La validación (que ya sabemos que funciona)
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ], [
            'email.unique' => '¡Esta patata ya tiene dueño! El correo ya está registrado.',
        ]);

        // 3. Guardamos en la mochila (sesión)
        session(['datos_registro' => $request->only('name', 'email', 'password')]);

        // 4. Redirigimos al Paso 2
        return redirect('/registro/paso2');
    }

    public function finalizarRegistro(Request $request)
    {
        // 1. Validamos que el usuario haya seleccionado TODAS las partes del avatar
        $request->validate([
            'avatar_base'        => 'required',
            'avatar_boca'        => 'required',
            'avatar_ojos'        => 'required',
            'avatar_complemento' => 'required',
        ], [
            'required' => '¡Tu patata no puede nacer incompleta! Elige todas las opciones.'
        ]);

        // 2. Recuperamos los datos del Paso 1 que guardamos en la sesión
        $datos = session('datos_registro');

        // SEGURIDAD: Si por alguna razón la sesión se perdió (tiempo expirado),
        // mandamos al usuario al principio para que no pete la app.
        if (!$datos) {
            return redirect()->route('registro')->with('error', 'La sesión ha caducado. Empieza de nuevo.');
        }

        // 3. Creamos al usuario con todo el pack completo
        $usuario = User::create([
            'name'               => $datos['name'],
            'email'              => $datos['email'],
            'password'           => Hash::make($datos['password']),
            'avatar_base'        => $request->avatar_base,
            'avatar_boca'        => $request->avatar_boca,
            'avatar_ojos'        => $request->avatar_ojos,
            'avatar_complemento' => $request->avatar_complemento,
        ]);

        // 4. Limpiamos la mochila (sesión)
        session()->forget('datos_registro');

        // 5. Iniciamos sesión automáticamente y mandamos a la Home
        Auth::login($usuario);

        return redirect()->to('/')->with('success', '¡Bienvenida al club de las patatas lectoras!');
    }


    
    public function logout(Request $request)
    {
        Auth::logout(); // Cerramos la sesión del usuario

        $request->session()->invalidate(); // Destruimos la sesión actual
        $request->session()->regenerateToken(); // Cambiamos el token CSRF por seguridad

        return redirect('/'); // ¡Aquí está el truco! Te manda a la Home de invitado
    }
}
