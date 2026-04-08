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
        // 1. Recogemos lo que el usuario escribió (ya sea en el Nav o en la página)
        $query = $request->input('query');
        $libros = [];

        // 2. Si no hay búsqueda (primera vez que entra), mandamos a la vista con lista vacía
        if (!$query) {
            return view('libros.index', ['libros' => []]);
        }

        // 3. Si hay búsqueda, cargamos los libros falsos (El Truco del Almendruco)
        // Nota: Más adelante aquí pondremos la conexión real a Google Books
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

        // 4. Devolvemos SIEMPRE a 'libros.index' para que se vea el buscador
        return view('libros.index', compact('libros'));
    }

    public function miEstanteria()
    {
        $usuario = Auth::user();
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
