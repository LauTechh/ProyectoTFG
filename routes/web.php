<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;

// 1. PÁGINA DE INICIO (Menú de invitado)
Route::get('/', function () {
    return view('menu');
})->name('home');

// 2. RUTAS DE ACCESO (Públicas: para usuarios no logueados)
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


// 3. RUTAS PROTEGIDAS (Solo para usuarios logueados con sus patatas)
Route::middleware(['auth'])->group(function () {

    // Perfil del usuario
    Route::get('/perfil', function () {
        return view('perfil');
    })->name('perfil');

    // MI ESTANTERÍA (Donde vemos los libros y las notas)
    Route::get('/my-shelf', [BookController::class, 'myShelf'])->name('books.myShelf');

    // BUSCADOR Y GUARDADO
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
    Route::post('/books/store', [BookController::class, 'store'])->name('books.store');

    // ELIMINAR LIBRO
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

    // LOGOUT (Cerrar sesión)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::put('/my-shelf/{book}', [BookController::class, 'updateShelf'])->name('books.updateShelf');
});
