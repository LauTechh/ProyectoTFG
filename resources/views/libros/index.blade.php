@extends('plantilla.app')

@section('content')
<div class="container mx-auto p-6">

    <div class="caja-beige-selector" style="text-align: left; margin-bottom: 30px;">
        <h2 style="color: #7c2d12; margin-bottom: 10px;">🔍 Buscar Libros para mi Colección</h2>

        {{-- CORRECCIÓN: 'books.search' -> 'libros.buscar' --}}
        <form action="{{ route('libros.buscar') }}" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="query" placeholder="Ej: Harry Potter..."
                style="flex: 1; padding: 12px; border: 2px solid #fed7aa; border-radius: 10px; outline: none;"
                class="focus:border-orange-400">

            {{-- Usamos la clase btn-primario de tu app.css --}}
            <button type="submit" class="btn-primario">Buscar</button>
        </form>
    </div>

    @if(isset($books) && count($books) > 0)
    <div class="lista-resultados-busqueda"> {{-- Clase de tu app.css --}}
        @foreach($books as $book)

        <div class="fila-libro"> {{-- Clase de tu app.css --}}
            {{-- Portada --}}
            <img src="{{ $book['cover_url'] ?? 'https://via.placeholder.com/150' }}" class="img-portada-libro">

            {{-- Información --}}
            <div class="info-libro-caja">
                <h3 class="titulo-libro">{{ $book['title'] }}</h3>
                <p class="autor-libro">{{ $book['author'] }}</p>
            </div>

            {{-- Etiqueta de Género --}}
            <span class="genero-libro-etiqueta">
                {{ $book['genre'] ?? 'General' }}
            </span>

            {{-- Acción de Guardar --}}
            {{-- CORRECCIÓN: 'books.store' -> 'libros.guardar' --}}
            <form action="{{ route('libros.guardar') }}" method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $book['title'] }}">
                <input type="hidden" name="author" value="{{ $book['author'] }}">
                <input type="hidden" name="cover_url" value="{{ $book['cover_url'] }}">
                <input type="hidden" name="genre" value="{{ $book['genre'] ?? 'General' }}">

                <button type="submit" class="btn-añadir-estanteria">+ Añadir</button>
            </form>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection