@extends('plantilla.app')

@section('content')
<div class="contenedor-estanteria-manual">
    <h2 class="titulo-biblioteca">Estantería de {{ $amigo->name }} 🥔</h2>

    <div class="rejilla-libros">
        @forelse($books as $book)
        <div class="tarjeta-libro-estanteria">

            <div class="contenedor-portada-estanteria">
                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="img-portada-estanteria">
            </div>

            <div class="cuerpo-tarjeta-estanteria">
                <h3 class="titulo-estanteria">{{ $book->title }}</h3>
                <p class="autor-estanteria">{{ $book->author }}</p>

                <div class="separador-tarjeta"></div>

                <div class="fila-control">
                    <span style="font-weight: 700; color: #8b5e3c;">Género</span>
                    <strong class="etiqueta-lectura">
                        {{ $book->genre ?? 'Ficción' }}
                    </strong>
                </div>

                <div class="fila-control">
                    <span style="font-weight: 700; color: #8b5e3c;">Estado</span>
                    <span class="badge-lectura">
                        @if($book->pivot->estado == 'leyendo') 👓 Leyendo
                        @elseif($book->pivot->estado == 'leido') ✅ Leído
                        @else 📖 Por leer @endif
                    </span>

                    <span class="nota-patata">
                        {{ str_repeat('🥔', $book->pivot->puntuacion ?? 0) }}
                    </span>
                </div>
            </div>
            @empty
            <p style="color: white; text-align: center; width: 100%;">{{ $amigo->name }} aún no tiene libros. 🥔</p>
            @endforelse
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/visitar-perfil/' . $amigo->id) }}" class="btn-primario">⬅ Volver al perfil</a>
        </div>
    </div>
    @endsection