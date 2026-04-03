<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Este es el "teléfono" para llamar a Google
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    // 1. Esta función solo muestra la página de búsqueda
    public function index()
    {
        return view('books.index');
    }

    // 2. Esta función es la que "llama" a Google Books
    public function search(Request $request)
    {
        $query = $request->input('query'); // Lo que tú escribas en el buscador

        // Llamamos a la API de Google
        $response = Http::get("https://www.googleapis.com/books/v1/volumes", [
            'q' => $query,
            'maxResults' => 10, // Traemos 10 libros para elegir
        ]);

        $books = $response->json()['items'] ?? [];

        return view('books.results', compact('books'));
    }

    public function store(Request $request)
    {
        // Usamos el Facade Auth directamente, que es más estable
        if (Auth::check()) { // Comprobamos si estás logueada por si acaso
            $userId = Auth::id();

            Book::create([
                'title'       => $request->title,
                'author'      => $request->author,
                'genre'       => $request->genre,
                'description' => $request->description, // Por si lo tienes en el form
                'cover_url'   => $request->cover_url,
                'user_id'     => $userId,
            ]);

            return redirect()->route('books.index')->with('success', '¡Libro añadido a tu estantería!');
        }

        // Si por algún motivo no estás logueada, te mandamos al login
        return redirect()->route('login')->with('error', 'Debes estar logueada para añadir libros.');
    }

    public function myShelf()
    {
        // Esto solo trae los libros QUE SON TUYOS
        $books = Auth::user()->books;

        return view('books.my-shelf', compact('books'));
    }


    public function destroy(Book $book)
    {
        // Seguridad: Solo el dueño puede borrarlo
        if ($book->user_id !== auth()->id()) {
            abort(403);
        }

        $book->delete();

        return redirect()->back()->with('success', '¡Patata-libro eliminada!');
    }
}
