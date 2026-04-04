@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">

    <div class="search-results-list">
        @foreach($books as $book)
            @php
                /* 🌟 EXTRAEMOS LOS DATOS AQUÍ PARA QUE NO DEN ERROR 🌟 */
                $info = $book['volumeInfo'] ?? [];
                $title = $info['title'] ?? 'Sin título';
                $author = implode(', ', $info['authors'] ?? ['Desconocido']);
                $cover = $info['imageLinks']['thumbnail'] ?? 'https://via.placeholder.com/150';
                
                // Aquí definimos $genre para que la línea 3 no falle
                $genre = isset($info['categories']) ? $info['categories'][0] : 'General';
            @endphp

            <div class="book-row">
                {{-- A. Portada --}}
                <img src="{{ $cover }}" class="book-row-img">

                {{-- B. Título y Autor --}}
                <div class="book-row-info">
                    <h3 class="book-row-title">{{ $title }}</h3>
                    <p class="book-row-author">{{ $author }}</p>
                </div>

                {{-- C. Género (La línea que fallaba) --}}
                <span class="book-row-genre">
                    {{ $genre }}
                </span>

                {{-- D. Acciones --}}
                <div class="book-row-actions">
                    @auth
                    <form action="{{ route('books.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="title" value="{{ $title }}">
                        <input type="hidden" name="author" value="{{ $author }}">
                        <input type="hidden" name="genre" value="{{ $genre }}">
                        <input type="hidden" name="cover_url" value="{{ $cover }}">
                        <button type="submit" class="btn-add-shelf">+ Añadir</button>
                    </form>
                    @endauth
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection