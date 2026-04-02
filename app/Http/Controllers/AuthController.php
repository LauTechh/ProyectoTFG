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
    // 1. Recuperamos los datos básicos de la sesión (nombre, email, pass)
    $datos = session('datos_registro');

    // 2. Creamos al usuario con las 4 capas que vienen del formulario
    $usuario = User::create([
        'name'     => $datos['name'],
        'email'    => $datos['email'],
        'password' => Hash::make($datos['password']),
        
        // Aquí usamos los nombres EXACTOS de los "name" de tus radio buttons
        'avatar_base'        => $request->avatar_base,        // La patata de color
        'avatar_boca'        => $request->avatar_boca,        // La boca seleccionada
        'avatar_ojos'        => $request->avatar_ojos,        // Los ojos seleccionados
        'avatar_complemento' => $request->avatar_complemento, // El accesorio
    ]);

    // 3. Limpiamos la sesión para no dejar basura
    session()->forget('datos_registro');

    // 4. Logueamos y entramos
    Auth::login($usuario);
    return redirect()->to('/');
}

    public function logout(Request $request)
    {
        Auth::logout(); // Cerramos la sesión del usuario

        $request->session()->invalidate(); // Destruimos la sesión actual
        $request->session()->regenerateToken(); // Cambiamos el token CSRF por seguridad

        return redirect('/'); // ¡Aquí está el truco! Te manda a la Home de invitado
    }
}
