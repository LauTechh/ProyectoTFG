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
        // 1. La validación total (Nombre, Email, Password + Pack Patata)
        $request->validate([
            'name'               => 'required|string|max:255',
            'email'              => 'required|email|unique:users,email',
            'password'           => 'required|min:6',
            // Validamos que la patata no nazca incompleta
            'avatar_base'        => 'required',
            'avatar_boca'        => 'required',
            'avatar_ojos'        => 'required',
            'avatar_complemento' => 'required',
        ], [
            'email.unique' => '¡Esta patata ya tiene dueño! El correo ya está registrado.',
            'required'     => '¡Tu patata no puede nacer incompleta! Elige todas las opciones.'
        ]);

        // 2. Creamos al usuario con el pack completo de una sola vez
        $usuario = User::create([
            'name'               => $request->name,
            'email'              => $request->email,
            'password'           => Hash::make($request->password),
            'avatar_base'        => $request->avatar_base,
            'avatar_boca'        => $request->avatar_boca,
            'avatar_ojos'        => $request->avatar_ojos,
            'avatar_complemento' => $request->avatar_complemento,
        ]);

        // 3. Iniciamos sesión automáticamente
        Auth::login($usuario);

        // 4. ¡A la Home con su nueva identidad!
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
