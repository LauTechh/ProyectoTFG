<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;

// 1. PÁGINA DE INICIO (Pública)
Route::get('/', function () {
    return view('menu');
})->name('home');

// 2. RUTAS DE ACCESO (Públicas)
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/registro', function () {
    return view('registro.registro');
})->name('registro');

Route::post('/registro', [AuthController::class, 'registrar']);
Route::get('/registro/paso2', function () {
    return view('registro.paso2');
});
Route::post('/registro/finalizar', [AuthController::class, 'finalizarRegistro'])->name('registro.finalizar');

// --- 🌟 RUTA DE BÚSQUEDA LIBRE 🌟 ---
// La sacamos del middleware para que los invitados puedan ver resultados
Route::get('/books/search', [BookController::class, 'search'])->name('books.search');


// 3. RUTAS PROTEGIDAS (Solo para usuarios logueados)
Route::middleware(['auth'])->group(function () {

    // Perfil del usuario
    Route::get('/perfil', function () {
        return view('perfil');
    })->name('perfil');

    // MI ESTANTERÍA
    Route::get('/my-shelf', [BookController::class, 'myShelf'])->name('books.myShelf');

    // GESTIÓN DE LIBROS (Aquí sí necesitas estar logueado para guardar o borrar)
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::post('/books/store', [BookController::class, 'store'])->name('books.store');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::put('/my-shelf/{book}', [BookController::class, 'updateShelf'])->name('books.updateShelf');

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});