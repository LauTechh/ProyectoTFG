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
    return view('registro');
});

// Para procesar los datos cuando pulses el botón
Route::post('/registro', [AuthController::class, 'registrar']);