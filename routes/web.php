<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\AmigoController;

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
| 2. RUTAS DE ACCESO (Login y Registro)
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| 2. RUTAS DE ACCESO (Login y Registro)
|--------------------------------------------------------------------------
*/

// Ahora el controlador decide qué vista mostrar
Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registrar']);

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
Route::middleware(['auth'])->group(function () { // <-- Aquí faltaban los ()

    // --- PERFIL Y AVATAR ---
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');

    Route::get('/perfil/editar-avatar', [PerfilController::class, 'editarAvatar'])->name('perfil.editar-avatar');
    Route::put('/perfil/actualizar-avatar', [PerfilController::class, 'actualizarAvatar'])->name('perfil.actualizar-avatar');
    Route::post('/perfil/actualizar-nombre', [PerfilController::class, 'actualizarNombre'])->name('perfil.actualizarNombre');

    // --- ESTANTERÍA Y GESTIÓN DE LIBROS ---
    Route::get('/mi-estanteria', [LibroController::class, 'miEstanteria'])->name('libros.estanteria');

    // 🔍 NUEVA RUTA PARA EL FILTRO AJAX
    Route::get('/estanteria/filtrar', [LibroController::class, 'filtrar'])->name('libros.filtrar');

    Route::get('/libros', [LibroController::class, 'inicio'])->name('libros.inicio');
    Route::post('/libros/guardar', [LibroController::class, 'guardar'])->name('libros.guardar')->middleware('auth');
    Route::delete('/libros/{libro}', [LibroController::class, 'eliminar'])->name('libros.eliminar');
    Route::put('/mi-estanteria/{libro}', [LibroController::class, 'actualizarEstanteria'])->name('libros.actualizar');

    // --- SALAS DE CONCENTRACIÓN ---
    Route::get('/salas', [SalaController::class, 'index'])->name('salas.index');
    Route::get('/salas/{tipo}', [SalaController::class, 'show'])->name('salas.show');
    Route::post('/salas/guardar', [SalaController::class, 'guardar'])->name('salas.guardar');

    // 🎯 ESTA ES LA RUTA NUEVA PARA EL PULSO AUTOMÁTICO
    Route::post('/salas/registrar-pulso', [SalaController::class, 'registrarPulso'])->name('salas.pulso');


    // --- SISTEMA DE AMIGOS ---
    // --- SISTEMA DE AMIGOS ---
    Route::get('/buscar-amigos', [AmigoController::class, 'index'])->name('amigos.index');
    Route::post('/amigos/enviar/{id}', [AmigoController::class, 'enviarSolicitud'])->name('amigos.enviar');
    Route::post('/amigos/aceptar/{id}', [AmigoController::class, 'aceptarSolicitud'])->name('amigos.aceptar');

    // Esta es la que nos estaba dando el error 500
    Route::post('/amigos/rechazar/{id}', [AmigoController::class, 'rechazarSolicitud'])->name('amigos.rechazar');

    Route::delete('/amigos/eliminar/{id}', [AmigoController::class, 'eliminarAmigo'])->name('amigos.eliminar');
    // --- VISITAS A AMIGOS (ESTANTERÍA Y PERFIL) ---
    // Hemos quitado el "use" de aquí porque ya está arriba del todo
    Route::get('/buscar-libros-amigo/{id}', [PerfilController::class, 'verEstanteriaAmigo'])->name('amigo.estanteria');
    Route::get('/visitar-perfil/{id}', [AmigoController::class, 'visitarPerfil'])->name('amigos.visitar');
}); // <-- Asegúrate de que termine con });
