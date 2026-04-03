<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Este es el "teléfono" para llamar a Google
use App\Models\Book;

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
        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'genre' => $request->genre,
            'cover_url' => $request->cover_url,
        ]);

        return redirect()->route('books.index')->with('success', '¡Libro añadido a tu red de patatas!');
    }
}
