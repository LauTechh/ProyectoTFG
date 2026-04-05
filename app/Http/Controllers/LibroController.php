<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Libro; // <-- CAMBIO 1: Importamos Libro, no Book
use Illuminate\Support\Facades\Auth;

class LibroController extends Controller
{
    public function inicio()
    {
        return view('libros.index');
    }

    public function buscar(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return view('libros.resultados', ['libros' => []]);
        }

        // --- COMIENZA EL TRUCO DEL ALMENDRUCO ---
        // Creamos una lista de libros falsos para que puedas trabajar sin conexión a Google
        $libros = [
            [
                'volumeInfo' => [
                    'title' => 'El misterio de la patata dorada',
                    'authors' => ['Pepe Patatón'],
                    'categories' => ['Aventura'],
                    'imageLinks' => ['thumbnail' => 'https://via.placeholder.com/150/f97316/ffffff?text=Libro+1']
                ]
            ],
            [
                'volumeInfo' => [
                    'title' => 'Laravel para mentes inquietas',
                    'authors' => ['Programadora Estrella'],
                    'categories' => ['Tecnología'],
                    'imageLinks' => ['thumbnail' => 'https://via.placeholder.com/150/fb923c/ffffff?text=Libro+2']
                ]
            ],
            [
                'volumeInfo' => [
                    'title' => 'Harry Potter y la API bloqueada',
                    'authors' => ['J.K. Rowling'],
                    'categories' => ['Fantasía'],
                    'imageLinks' => ['thumbnail' => 'https://via.placeholder.com/150/fdba74/ffffff?text=Libro+3']
                ]
            ]
        ];

        // Devolvemos la vista con estos libros falsos
        return view('libros.resultados', compact('libros'));
        // --- TERMINA EL TRUCO DEL ALMENDRUCO ---


        /* Mantenemos esto comentado para que no se pierda, 
       lo activaremos cuando Google nos perdone:

    try {
        $response = Http::withoutVerifying()
            ->timeout(10)
            ->get("https://www.googleapis.com/books/v1/volumes", [
                'q' => $query,
                'maxResults' => 20,
            ]);

        if ($response->successful()) {
            $datos = $response->json();
            $libros = $datos['items'] ?? [];
            return view('libros.resultados', compact('libros'));
        }
        ...
    } catch (\Exception $e) { ... }
    */
    }

    public function guardar(Request $request)
    {
        // Si la petición viene de JavaScript, recogemos los datos del JSON
        $data = $request->isJson() ? $request->all() : $request->all();

        if (Auth::check()) {
            $libro = Libro::firstOrCreate(
                ['title' => $data['title'], 'author' => $data['author']],
                [
                    'genre'       => $data['genre'],
                    'cover_url'   => $data['cover_url'],
                    'user_id'     => Auth::id(),
                ]
            );

            Auth::user()->libros()->syncWithoutDetaching([$libro->id => [
                'estado' => 'por_leer',
                'puntuacion' => 1
            ]]);

            // RESPUESTA PARA JAVASCRIPT
            return response()->json([
                'success' => true,
                'message' => '¡' . $libro->title . ' guardado!'
            ]);
        }

        return response()->json(['success' => false, 'message' => 'No autorizado'], 401);
    }

    public function miEstanteria()
    {
        $usuario = Auth::user();
        // CAMBIO 3: Usamos la relación libros() que definimos en User.php
        $books = $usuario->libros()->withPivot('estado', 'puntuacion')->get();

        return view('libros.estanteria', compact('books'));
    }

    // Antes: public function actualizarEstanteria(Request $request, $libroId)
    public function actualizarEstanteria(Request $request, Libro $libro) // <--- Cambiado a $libro
    {
        $usuario = Auth::user();
        $usuario->libros()->updateExistingPivot($libro->id, [ // <--- Usamos $libro->id
            'estado' => $request->estado,
            'puntuacion' => $request->puntuacion
        ]);
        return redirect()->back()->with('success', '¡Libro actualizado!');
    }

    public function eliminar(Libro $libro) // CAMBIO 5: Type-hinting con Libro
    {
        if ($libro->user_id !== Auth::id()) {
            abort(403);
        }

        $libro->delete();

        return redirect()->back()->with('success', '¡Patata-libro eliminada!');
    }
}
