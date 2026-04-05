<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PerfilController; // Asegúrate de tener el controlador

/*
|--------------------------------------------------------------------------
| 1. PÁGINA DE INICIO (Pública)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('menu');
})->name('home');


/*
|--------------------------------------------------------------------------
| 2. RUTAS DE ACCESO (Públicas: Login y Registro)
|--------------------------------------------------------------------------
*/

// --- LOGIN ---
Route::get('/login', function () {
    return view('login'); // Asegúrate de que login.blade.php esté en la raíz de views
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

// --- REGISTRO (Carpeta 'registro') ---
Route::get('/registro', function () {
    return view('registro.registro'); // resources/views/registro/registro.blade.php
})->name('registro');

Route::post('/registro', [AuthController::class, 'registrar']);

Route::get('/registro/paso2', function () {
    return view('registro.paso2'); // resources/views/registro/paso2.blade.php
})->name('registro.paso2');

Route::post('/registro/finalizar', [AuthController::class, 'finalizarRegistro'])->name('registro.finalizar');


/*
|--------------------------------------------------------------------------
| 3. BÚSQUEDA DE LIBROS (Pública para todos)
|--------------------------------------------------------------------------
*/
Route::get('/libros/buscar', [LibroController::class, 'buscar'])->name('libros.buscar');


/*
|--------------------------------------------------------------------------
| 4. RUTAS PROTEGIDAS (Solo para usuarios logueados)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --- PERFIL ---
    Route::get('/perfil', function () {
        return view('perfil');
    })->name('perfil');

    // --- ESTANTERÍA PERSONAL ---
    Route::get('/mi-estanteria', [LibroController::class, 'miEstanteria'])->name('libros.estanteria');

    // --- GESTIÓN DE LIBROS ---
    Route::get('/libros', [LibroController::class, 'inicio'])->name('libros.inicio');
    Route::post('/libros/guardar', [LibroController::class, 'guardar'])->name('libros.guardar');
    Route::delete('/libros/{libro}', [LibroController::class, 'eliminar'])->name('libros.eliminar');
    Route::put('/mi-estanteria/{libro}', [LibroController::class, 'actualizarEstanteria'])->name('libros.actualizar');

    // --- SALIR (LOGOUT) ---
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::middleware('auth')->group(function () {
    // Ruta para mostrar la vista de edición
    Route::get('/perfil/editar-avatar', [PerfilController::class, 'editarAvatar'])->name('perfil.editar-avatar');

    // Ruta para guardar los cambios (usamos PUT porque es una actualización)
    Route::put('/perfil/actualizar-avatar', [PerfilController::class, 'actualizarAvatar'])->name('perfil.actualizar-avatar');
});
