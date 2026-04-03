<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\BookController;


// 1. LA HOME AHORA ES TU MENÚ DE INVITADO
Route::get('/', function () {
    return view('menu'); // Mostramos el menú a todo el mundo
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

// 3. RUTAS PROTEGIDAS (Solo para logueados)
Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', function () {
        return view('perfil');
    })->name('perfil');

    Route::get('/mis-libros', function () {
        return view('mis-libros'); // Tu futura biblioteca
    })->name('mis.libros');
});

// 4. LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Ruta para ver el buscador
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// Ruta para procesar la búsqueda en Google
Route::get('/books/search', [BookController::class, 'search'])->name('books.search');

// Ruta para guardar el libro elegido en tu base de datos (la prepararemos luego)
Route::post('/books/store', [BookController::class, 'store'])->name('books.store');

Route::get('/my-shelf', [BookController::class, 'myShelf'])->name('books.myShelf');

Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
