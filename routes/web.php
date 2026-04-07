<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SalaController;

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
| 2. RUTAS DE ACCESO (Login y Registro Unificado)
|--------------------------------------------------------------------------
*/

// --- LOGIN ---
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

// --- REGISTRO ---
Route::get('/registro', function () {
    // Apuntamos a tu vista de registro (donde ahora está el selector de avatar)
    return view('registro.registro');
})->name('registro');

// Esta es la ruta que recibe el nombre, email, pass Y avatar a la vez
Route::post('/registro', [AuthController::class, 'registrar']);

// --- LOGOUT ---
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| 3. BÚSQUEDA DE LIBROS (Pública)
|--------------------------------------------------------------------------
*/
Route::get('/libros/buscar', [LibroController::class, 'buscar'])->name('libros.buscar');


/*
|--------------------------------------------------------------------------
| 4. RUTAS PROTEGIDAS (Solo para usuarios logueados)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // --- PERFIL Y AVATAR ---
    Route::get('/perfil', function () {
        return view('perfil');
    })->name('perfil');

    Route::get('/perfil/editar-avatar', [PerfilController::class, 'editarAvatar'])->name('perfil.editar-avatar');
    Route::put('/perfil/actualizar-avatar', [PerfilController::class, 'actualizarAvatar'])->name('perfil.actualizar-avatar');
    Route::post('/perfil/actualizar-nombre', [PerfilController::class, 'actualizarNombre'])->name('perfil.actualizarNombre');

    // --- ESTANTERÍA Y GESTIÓN DE LIBROS ---
    Route::get('/mi-estanteria', [LibroController::class, 'miEstanteria'])->name('libros.estanteria');
    Route::get('/libros', [LibroController::class, 'inicio'])->name('libros.inicio');
    Route::post('/libros/guardar', [LibroController::class, 'guardar'])->name('libros.guardar');
    Route::delete('/libros/{libro}', [LibroController::class, 'eliminar'])->name('libros.eliminar');
    Route::put('/mi-estanteria/{libro}', [LibroController::class, 'actualizarEstanteria'])->name('libros.actualizar');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/salas', [SalaController::class, 'index'])->name('salas.index');
    Route::get('/salas/{tipo}', [SalaController::class, 'show'])->name('salas.show');
    Route::post('/salas/guardar', [SalaController::class, 'guardar'])->name('salas.guardar');
});
