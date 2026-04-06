@extends('plantilla.app')

@section('content')
<div class="container mx-auto p-6">

    <div class="caja-beige-selector" style="text-align: left; margin-bottom: 30px;">
        <h2 style="color: #7c2d12; margin-bottom: 10px;">🔍 Buscar Libros para mi Colección</h2>

        <form action="{{ route('libros.buscar') }}" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="query" placeholder="Ej: Harry Potter..."
                style="flex: 1; padding: 12px; border: 2px solid #fed7aa; border-radius: 10px; outline: none;"
                class="focus:border-orange-400"
                value="{{ request('query') }}">

            <button type="submit" class="btn-primario">Buscar</button>
        </form>
    </div>

    @if(isset($books) && count($books) > 0)
    <div class="lista-resultados-busqueda">
        @foreach($books as $book)

        <div class="fila-libro">
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
            <div class="acciones-libro">
                @auth
                {{-- SI ESTÁ LOGUEADO: Formulario normal --}}
                <form action="{{ route('libros.guardar') }}" method="POST">
                    @csrf
                    <input type="hidden" name="title" value="{{ $book['title'] }}">
                    <input type="hidden" name="author" value="{{ $book['author'] }}">
                    <input type="hidden" name="cover_url" value="{{ $book['cover_url'] }}">
                    <input type="hidden" name="genre" value="{{ $book['genre'] ?? 'General' }}">

                    <button type="submit" class="btn-añadir-estanteria">+ Añadir</button>
                </form>
                @else
                {{-- SI ES INVITADO: Botón con clase para el JS y color gris --}}
                <button type="button" class="btn-añadir-estanteria js-invitado">
                    + Añadir
                </button>
                @endauth
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>

{{-- Script rápido por si no quieres pelearte con el compilador de JS ahora mismo --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const botonesInvitado = document.querySelectorAll('.js-invitado');
        botonesInvitado.forEach(boton => {
            boton.addEventListener('click', function() {
                alert("¡Hola! 🥔 Para añadir este libro a tu biblioteca, necesitas iniciar sesión o crear una cuenta.");
            });
        });
    });
</script>

@endsection