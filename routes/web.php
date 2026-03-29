<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
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
Route::post('/registro/finalizar', [AuthController::class, 'finalizarRegistro']);

Route::get('/menu', function () {
    return view('menu');
})->middleware('auth'); // El middleware 'auth' hace que solo entren los que se han logueado