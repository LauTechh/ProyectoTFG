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
        // 1. Validación (La mantenemos igual, está genial)
        $request->validate([
            'name'               => 'required|string|max:255',
            'email'              => 'required|email|unique:users,email',
            'password'           => 'required|min:6',
            'avatar_base'        => 'required',
            'avatar_boca'        => 'required',
            'avatar_ojos'        => 'required',
            'avatar_complemento' => 'required',
        ], [
            'email.unique' => '¡Esta patata ya tiene dueño! El correo ya está registrado.',
            'required'     => '¡Tu patata no puede nacer incompleta! Elige todas las opciones.'
        ]);

        // 2. Creamos al usuario concatenando el nombre del archivo
        // Esto asegura que en la BD se guarde "azulRelleno.png" y no solo "azul"
        $usuario = User::create([
            'name'               => $request->name,
            'email'              => $request->email,
            'password'           => Hash::make($request->password),

            // Si el value del radio es "azul", guardará "azulRelleno.png"
            'avatar_base'        => $request->avatar_base . 'Relleno.png',

            // Si tus archivos de boca/ojos/complemento YA terminan en .png en el value del HTML, 
            // déjalos como estaban. Si no, añade el .png aquí también:
            'avatar_boca'        => $request->avatar_boca . '.png',
            'avatar_ojos'        => $request->avatar_ojos . '.png',
            'avatar_complemento' => $request->avatar_complemento . '.png',
        ]);

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
