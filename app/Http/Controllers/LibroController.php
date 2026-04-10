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
        $query = $request->input('query');

        if (!$query) {
            return view('libros.index', ['libros' => []]);
        }

        // 1. Catálogo de prueba con un libro por cada uno de tus géneros
        $libros = [
            [
                'volumeInfo' => [
                    'title' => 'Harry Potter y la API Bloqueada',
                    'authors' => ['J.K. Rowling'],
                    'categories' => ['Juvenile Fiction / Fantasy'], // Debería ser Fantasía
                    'imageLinks' => ['thumbnail' => 'https://via.placeholder.com/150/fdba74/ffffff?text=Fantasía']
                ]
            ],
            [
                'volumeInfo' => [
                    'title' => 'Drácula en el Servidor',
                    'authors' => ['Bram Stoker'],
                    'categories' => ['Horror'], // Debería ser Terror
                    'imageLinks' => ['thumbnail' => 'https://via.placeholder.com/150/7f1d1d/ffffff?text=Terror']
                ]
            ],
            [
                'volumeInfo' => [
                    'title' => 'Orgullo y Programación',
                    'authors' => ['Jane Austen'],
                    'categories' => ['Romance'], // Debería ser Romance
                    'imageLinks' => ['thumbnail' => 'https://via.placeholder.com/150/db2777/ffffff?text=Romance']
                ]
            ],
            [
                'volumeInfo' => [
                    'title' => 'Crónicas Marcianas de PHP',
                    'authors' => ['Ray Bradbury'],
                    'categories' => ['Science Fiction'], // Debería ser Ciencia Ficción
                    'imageLinks' => ['thumbnail' => 'https://via.placeholder.com/150/2563eb/ffffff?text=Ciencia+Ficcion']
                ]
            ],
            [
                'volumeInfo' => [
                    'title' => 'El Quijote del Código',
                    'authors' => ['Miguel de Cervantes'],
                    'categories' => ['Classics'], // Debería ser Clásicos
                    'imageLinks' => ['thumbnail' => 'https://via.placeholder.com/150/78350f/ffffff?text=Clasicos']
                ]
            ],
            [
                'volumeInfo' => [
                    'title' => 'Indiana Jones y el Token Perdido',
                    'authors' => ['George Lucas'],
                    'categories' => ['Action & Adventure'], // Debería ser Aventura
                    'imageLinks' => ['thumbnail' => 'https://via.placeholder.com/150/059669/ffffff?text=Aventura']
                ]
            ],
            [
                'volumeInfo' => [
                    'title' => 'Sapiens: De Bits a Humanos',
                    'authors' => ['Yuval Noah Harari'],
                    'categories' => ['History'], // Debería ser Historia
                    'imageLinks' => ['thumbnail' => 'https://via.placeholder.com/150/4b5563/ffffff?text=Historia']
                ]
            ],
            [
                'volumeInfo' => [
                    'title' => 'Una Novela Genérica',
                    'authors' => ['Autor Desconocido'],
                    'categories' => ['Literary Fiction'], // Debería ser Ficción
                    'imageLinks' => ['thumbnail' => 'https://via.placeholder.com/150/d1d5db/ffffff?text=Ficcion']
                ]
            ]
        ];

        // 2. 🎯 ¡IMPORTANTE! Aplicamos el traductor a cada libro de prueba
        // Así verificamos que el "LIKE" simulado funciona con los fragmentos
        foreach ($libros as &$libro) {
            $generoGoogle = $libro['volumeInfo']['categories'][0] ?? 'Varios';
            $libro['genero_nuestro'] = $this->traducirGenero($generoGoogle);
        }

        return view('libros.resultados', compact('libros'));
    }


    public function guardar(Request $request)
    {
        try {
            // 🎯 Usamos la función privada para no repetir código
            $generoFinal = $this->traducirGenero($request->genero);

            $libro = Libro::firstOrCreate(
                ['title' => $request->titulo, 'author' => $request->autor],
                [
                    'cover_url' => $request->portada,
                    'genre' => $generoFinal,
                    'user_id' => auth()->id()
                ]
            );

            \DB::table('book_user')->updateOrInsert(
                ['user_id' => auth()->id(), 'book_id' => $libro->id],
                [
                    'estado' => 'por_leer',
                    'puntuacion' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );

            return response()->json([
                'success' => true,
                'message' => "¡Patata guardada en $generoFinal! 🥔"
            ]);
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
        // 1. Actualizamos el género en la tabla 'libros'
        // Usamos fill o update para que el cambio de género sea permanente
        $libro->update([
            'genre' => $request->genero
        ]);

        // 2. Actualizamos la relación pivot (estado y puntuación)
        $usuario = Auth::user();
        $usuario->libros()->updateExistingPivot($libro->id, [
            'estado' => $request->estado,
            'puntuacion' => $request->puntuacion
        ]);

        return redirect()->back()->with('success', '¡Libro y género actualizados! 🥔✨');
    }



    public function filtrar(Request $request)
    {
        $genero = $request->get('genero');
        $user = auth()->user();

        if ($genero === 'todos') {
            $books = $user->books; // Ajusta 'books' según tu relación en el modelo User
        } else {
            $books = $user->books()->where('genre', $genero)->get();
        }

        $html = view('partials.lista_libros_estanteria', compact('books'))->render();

        return response()->json(['html' => $html]);
    }



    // resources/app/Http/Controllers/LibroController.php

    public function eliminar(Libro $libro)
    {
        $usuario = auth()->user();

        // 1. Rompemos la relación en la tabla intermedia (book_user)
        // Esto NO borra el libro de la tabla 'libros', solo lo quita de TU lista.
        $usuario->libros()->detach($libro->id);

        return redirect()->back()->with('success', '¡Libro quitado de tu estantería! 🥔');
    }
















    // --- FUNCIÓN PRIVADA DE TRADUCCIÓN ---
    private function traducirGenero($generoOriginal)
    {
        $original = strtolower(trim($generoOriginal ?? 'Varios'));

        // Aquí definimos los "patrones SQL" (sin los %, porque PHP usa barras / /)
        $mapaGeneros = [
            'Fantasía' => ['fantas', 'magi', 'wizard', 'witch', 'potter', 'naranjo', 'myth'],
            'Terror'   => ['horror', 'terror', 'rror', 'miedo', 'ghos', 'suspens'],
            'Romance'  => ['roman', 'love', 'amor', 'relat'],
            'Ciencia Ficción' => ['scien', 'fi', 'space', 'robot', 'dystop'],
            'Clásicos' => ['classic', 'antiqu', 'ancient'],
            'Aventura' => ['avent', 'advent', 'action', 'explor'],
            'Historia' => ['histo', 'biogra'],
        ];

        foreach ($mapaGeneros as $categoriaOficial => $patrones) {
            foreach ($patrones as $patron) {
                // Esto es el equivalente a: WHERE genero LIKE '%$patron%'
                if (str_contains($original, $patron)) {
                    return $categoriaOficial;
                }
            }
        }

        // Si Google dice "Juvenile Fiction" y no cazamos nada arriba,
        // o si es cualquier otra cosa, lo dejamos como Ficción en español.
        return 'Ficción';
    }
}
