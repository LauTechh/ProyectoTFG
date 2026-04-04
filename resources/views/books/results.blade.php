@extends('layouts.app') {{-- Esto le dice: "Usa la plantilla que ya tenemos" --}}

@section('content') {{-- Esto le dice: "Mete todo esto dentro del hueco de contenido" --}}
<div class="container mx-auto p-6">


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($books as $book)
        @php
        $info = $book['volumeInfo'];
        $title = $info['title'] ?? 'Sin título';
        $author = implode(', ', $info['authors'] ?? ['Desconocido']);
        $cover = $info['imageLinks']['thumbnail'] ?? 'https://via.placeholder.com/150';
        $genre = $info['categories'][0] ?? 'General';
        @endphp

        <div class="card-menu flex flex-col items-center text-center p-4">
            <img src="{{ $cover }}" alt="{{ $title }}" class="w-32 h-48 object-cover rounded shadow-md mb-4">
            <h3 class="font-bold text-lg leading-tight">{{ $title }}</h3>
            <p class="text-gray-600 text-sm">{{ $author }}</p>
            <span class="text-xs bg-pink-100 text-pink-600 px-2 py-1 rounded-full mt-2">{{ $genre }}</span>

            {{-- Formulario para guardar el libro --}}
            {{-- Si está logueado: Botón de añadir --}}
            @auth
            <form action="{{ route('books.store') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="title" value="{{ $title }}">
                <input type="hidden" name="author" value="{{ $author }}">
                <input type="hidden" name="genre" value="{{ $genre }}">
                <input type="hidden" name="cover_url" value="{{ $cover }}">
                <button type="submit" class="btn-primary">Añadir a mi estantería</button>
            </form>
            @endauth

            {{-- Si es invitado: Enlace al registro --}}
            @guest
            <div class="mt-4">
                <a href="{{ route('registro') }}" class="btn-secondary">
                    ✨ Crea una cuenta para añadir libros
                </a>
            </div>
            @endguest
        </div>
        @endforeach
    </div>
</div>
@endsection {{-- Cerramos la sección --}}