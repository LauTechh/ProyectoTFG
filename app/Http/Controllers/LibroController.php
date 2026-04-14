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

        // 1. TUS LIBROS FALSOS (o los que vengan de la API)
        $libros = [
            [
                'volumeInfo' => [
                    'title' => 'El misterio de la patata dorada',
                    'authors' => ['Pepe Patatón'],
                    'categories' => ['Aventura'], // Google diría algo como "Action & Adventure"
                    'imageLinks' => ['thumbnail' => 'https://via.placeholder.com/150/f97316/ffffff?text=Libro+1']
                ]
            ],
            [
                'volumeInfo' => [
                    'title' => 'Laravel para mentes inquietas',
                    'authors' => ['Programadora Estrella'],
                    'categories' => ['Computers'], // Esto lo traduciremos a Ficción o Tecnología
                    'imageLinks' => ['thumbnail' => 'https://via.placeholder.com/150/fb923c/ffffff?text=Libro+2']
                ]
            ],
            [
                'volumeInfo' => [
                    'title' => 'Harry Potter y la API bloqueada',
                    'authors' => ['J.K. Rowling'],
                    'categories' => ['Juvenile Fiction / Fantasy'],
                    'imageLinks' => ['thumbnail' => 'https://via.placeholder.com/150/fdba74/ffffff?text=Libro+3']
                ]
            ]
        ];

        // 2. 🎯 PROCESAMOS LOS GÉNEROS ANTES DE ENVIARLOS A LA VISTA
        foreach ($libros as &$libro) {
            // Obtenemos el género original (el primero de la lista o 'Varios')
            $generoOriginal = $libro['volumeInfo']['categories'][0] ?? 'Varios';

            // Creamos una nueva clave 'genero_nuestro' con la traducción
            $libro['genero_nuestro'] = $this->traducirGenero($generoOriginal);
        }

        return view('libros.resultados', compact('libros'));
    }


    public function guardar(Request $request)
    {
        try {
            // 🎯 CAMBIO CLAVE: Combinamos género y título para que el traductor sea infalible
            $textoParaAnalizar = ($request->genero ?? '') . ' ' . ($request->titulo ?? '');
            $generoFinal = $this->traducirGenero($textoParaAnalizar);

            $libro = Libro::firstOrCreate(
                ['title' => $request->titulo, 'author' => $request->autor],
                [
                    'cover_url' => $request->portada,
                    'genre' => $generoFinal, // Se guarda ya traducido (ej: "Fantasía")
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

        // Usamos el query builder para que la base de datos trabaje por nosotros
        $query = $user->books();

        if ($genero !== 'todos' && !empty($genero)) {
            $query->where('genre', $genero);
        }

        $books = $query->get();

        // Renderizamos la vista parcial que ya tienes
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




    public function obtenerEstadisticasValoracion()
    {
        $user = auth()->user();

        $generosValorados = $user->books()
            ->select(
                'genre',
                \DB::raw('count(*) as total_libros'),
                \DB::raw('AVG(rating) as media_puntuacion') // Suponiendo que tu columna se llama 'rating'
            )
            ->groupBy('genre')
            ->orderBy('media_puntuacion', 'desc')
            ->get();

        return $generosValorados;
    }











    // --- FUNCIÓN PRIVADA DE TRADUCCIÓN ---
    private function traducirGenero($textoAnalizar)
    {
        $original = strtolower(trim($textoAnalizar ?? 'Varios'));

        $mapaGeneros = [
            // 1. PRIORIDAD MÁXIMA: Romántica
            'Romántica'       => ['amor', 'love', 'roman', 'relat', 'amo', 'noviazgo', 'beso'],

            // 2. Fantasía (Reforzada para Mistborn y similares)
            'Fantasía'        => [
                'fantas',
                'magia',
                'wizard',
                'witch',
                'potter',
                'myth',
                'dragones',
                'mistborn',
                'bruma',
                'épica',
                'epic',
                'sword',
                'espada',
                'sorcer'
            ],

            // 3. Policiaca y Terror
            'Policiaca'       => ['crimen', 'polic', 'detect', 'mister', 'noir', 'thrill', 'investig'],
            'Terror'          => ['horror', 'terror', 'miedo', 'ghos', 'suspens', 'paranormal'],

            // 4. Ciencia Ficción (Más patrones comunes)
            'Ciencia Ficción' => [
                'science fiction',
                'space',
                'robot',
                'dystop',
                'sci-fi',
                'futurist',
                'cyber',
                'estelar',
                'galact'
            ],

            'Aventura'        => ['aventur', 'adventur', 'action', 'explor'],
            'Historia'        => ['histor', 'biogra', 'war', 'guerra'],
            'Clásicos'        => ['classic', 'antiqu', 'ancient'],
        ];

        foreach ($mapaGeneros as $categoriaOficial => $patrones) {
            foreach ($patrones as $patron) {
                if (str_contains($original, $patron)) {
                    return $categoriaOficial;
                }
            }
        }

        // Tu cambio a Narrativa (¡queda genial!)
        return 'Narrativa';
    }
}
