<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Libro;
use Illuminate\Support\Facades\Auth;

class LibroController extends Controller
{
    public function inicio()
    {
        return view('libros.index');
    }


    public function buscar(Request $request)
    {
        // 1. Recogemos lo que el usuario escribió
        $query = $request->input('query');
        $libros = [];

        // 2. Si no hay búsqueda, se quedan en el buscador (index)
        if (!$query) {
            return view('libros.index', ['libros' => []]);
        }

        // 3. TUS LIBROS FALSOS (Para pruebas estéticas)
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

        // 4. 🎯 ¡EL CAMBIO! Ahora devolvemos la vista de resultados
        return view('libros.resultados', compact('libros'));
    }

    public function guardar(Request $request)
    {
        try {
            // 1. Buscamos o creamos el libro en la tabla 'libros'
            $libro = \App\Models\Libro::firstOrCreate(
                ['title' => $request->titulo, 'author' => $request->autor],
                [
                    'cover_url' => $request->portada,
                    'genre' => $request->genero ?? 'Varios',
                    'user_id' => auth()->id() // Mantenemos esto por si tu DB lo pide
                ]
            );

            // 2. ¡ESTO ES LO QUE LLENA TU ESTANTERÍA!
            // Forzamos la inserción en la tabla intermedia book_user
            \DB::table('book_user')->updateOrInsert(
                [
                    'user_id' => auth()->id(),
                    'book_id' => $libro->id
                ],
                [
                    'estado' => 'por_leer',
                    'puntuacion' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );

            return response()->json(['success' => true, 'message' => '¡Patata guardada! 🥔']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }




    public function miEstanteria()
    {
        $usuario = \App\Models\User::find(auth()->id());

        // Obtenemos los libros usando la relación que definimos en User.php
        $books = $usuario->libros()->withPivot('estado', 'puntuacion')->get();

        return view('libros.estanteria', compact('books'));
    }






    public function actualizarEstanteria(Request $request, Libro $libro)
    {
        $usuario = Auth::user();
        $usuario->libros()->updateExistingPivot($libro->id, [
            'estado' => $request->estado,
            'puntuacion' => $request->puntuacion
        ]);
        return redirect()->back()->with('success', '¡Libro actualizado!');
    }

    public function eliminar(Libro $libro)
    {
        if ($libro->user_id !== Auth::id()) {
            abort(403, 'No puedes borrar un libro que no has añadido tú.');
        }

        $libro->delete();

        return redirect()->back()->with('success', '¡Libro eliminado de tu estantería!');
    }
}
