<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('login');
});

// Esta ruta recibe los datos del formulario de login
Route::post('/login', [AuthController::class, 'login']);

// Para ver el formulario
Route::get('/registro', function () {
    return view('registro.registro'); // Antes era solo 'registro'
});

// Para procesar los datos cuando pulses el botón
Route::post('/registro', [AuthController::class, 'registrar']);
// Ruta para ver la pantalla de la patata
Route::get('/registro/paso2', function () {
    return view('registro.paso2');
});

// Ruta para procesar el envío final
// Esta es la ruta que le falta a tu Laravel:
Route::post('/registro/finalizar', [AuthController::class, 'finalizarRegistro'])->name('registro.finalizar');
Route::get('/menu', function () {
    return view('menu');
})->middleware('auth')->name('menu');


Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request . session()->invalidate();
    $request . session()->regenerateToken();
    return redirect('/');
});

Route::get('/perfil', function () {
    return view('perfil'); 
})->name('perfil')->middleware('auth');