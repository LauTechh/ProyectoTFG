@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6" style="display: block !important;"> {{-- Forzamos bloque aquí también --}}

    <div class="welcome-text-container mb-8">
        <h2 class="text-2xl font-bold">🔍 Buscar Libros para mi Colección</h2>
        <form action="{{ route('books.search') }}" method="GET" class="mt-4">
            <input type="text" name="query" placeholder="Ej: Harry Potter..."
                class="rounded-lg p-2 border-2 border-pink-200 text-black">
            <button type="submit" class="btn-primary">Buscar</button>
        </form>
    </div>

    @if(isset($books) && count($books) > 0)
    <div class="search-results-list">
        @foreach($books as $book)
        {{-- Contenedor principal de la fila --}}
        <div class="book-row">
            <img src="{{ $book['cover_url'] }}" class="book-row-img">

            <div class="book-row-info">
                <h3 class="book-row-title">{{ $book['title'] }}</h3>
                <p class="book-row-author">{{ $book['author'] }}</p>
            </div>

            <span class="book-row-genre">Fiction</span>

            <form action="{{ route('books.store') }}" method="POST">
                @csrf
                <button type="submit" class="btn-add-shelf">+ Añadir</button>
            </form>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection