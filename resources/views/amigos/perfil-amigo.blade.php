@extends('plantilla.app')

@section('content')
{{-- Cargamos ambos: el base y las correcciones específicas para amigos --}}
@vite(['resources/css/perfil.css', 'resources/css/perfil-amigo.css'])

<div class="contenedor-perfil-layout">

    {{-- COLUMNA IZQUIERDA (1/3): IDENTIDAD DEL AMIGO --}}
    <div class="columna-perfil-izq">
        <div class="tarjeta-decorativa shadow-sm" style="padding: 20px;">

            {{-- Avatar: El contenedor ya tiene el tamaño y forma por CSS --}}
            <div class="circulo-avatar-grande">
                {{-- Capas de la patata --}}
                <img src="{{ asset('img/avatar/base/' . basename($amigo->avatar_base ?? 'azulRelleno.png')) }}"
                    class="capa-v-avatar" style="z-index: 1;">

                <img src="{{ asset('img/avatar/ojos/' . basename($amigo->avatar_ojos ?? 'ojos1.png')) }}"
                    class="capa-v-avatar" style="z-index: 2;">

                <img src="{{ asset('img/avatar/boca/' . basename($amigo->avatar_boca ?? 'boca1.png')) }}"
                    class="capa-v-avatar mix-blend" style="z-index: 3;">

                @if($amigo->avatar_complemento)
                <img src="{{ asset('img/avatar/complemento/' . basename($amigo->avatar_complemento)) }}"
                    class="capa-v-avatar" style="z-index: 4;">
                @endif
            </div>

            <h3 class="nombre-usuario text-center" style="margin-top: 15px; color: #365314; font-weight: bold;">
                {{ $amigo->name }}
            </h3>

            <hr class="separador-perfil">

            {{-- Bloque de información extra --}}
            <div class="contenedor-relleno">
                <img src="https://via.placeholder.com/250x150?text=Info+Amigo"
                    alt="Relleno"
                    style="width: 100%; border-radius: 15px; border: 2px dashed #d1d5db; opacity: 0.6;">
                <p class="txt-decorativo" style="font-size: 0.7rem; margin-top: 10px; color: #666;">
                    Próximamente: Algo muy guay aquí... 🥔✨
                </p>
            </div>

            {{-- GRUPO DE BOTONES --}}
            <div class="grupo-botones-vertical" style="margin-top: 25px; display: flex; flex-direction: column; gap: 10px;">

                {{-- Nuevo botón para la estantería específica del amigo --}}
                {{-- En el grupo de botones --}}
                <a href="#seccion-estanteria" class="btn-perfil-navegacion" style="background-color: #fff7ed; border-color: #fb923c;">
                    📚 Ver Estantería
                </a>
                <a href="{{ url('/buscar-amigos?tab=mis-amigos') }}" class="btn-perfil-navegacion">
                    ⬅ Volver a mis amigos
                </a>
            </div>
        </div>
    </div>

    {{-- COLUMNA DERECHA (2/3): CONTENIDO DINÁMICO --}}
    <div class="columna-perfil-der" id="seccion-estanteria">
        <div class="tarjeta-decorativa shadow-sm" style="min-height: 500px; padding: 30px;">
            <h2 class="titulo-biblioteca">📚 Biblioteca de {{ $amigo->name }}</h2>
            <p class="text-muted">Echa un vistazo a lo que está leyendo tu amigo...</p>

            <hr class="separador-perfil">

            <div class="rejilla-libros-amigo" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 20px;">
                @forelse($books as $book)
                <div class="tarjeta-libro-estanteria">
                    <div class="contenedor-portada-estanteria">
                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" style="width: 100%; border-radius: 8px;">
                    </div>
                    <div class="cuerpo-tarjeta-estanteria" style="text-align: center; margin-top: 10px;">
                        <h4 style="font-size: 0.9rem; margin-bottom: 5px;">{{ $book->title }}</h4>

                        <div class="badge-estado" style="font-size: 0.8rem; background: #f3f4f6; border-radius: 12px; padding: 2px 8px; display: inline-block;">
                            @if($book->pivot->estado == 'leyendo') 👓 Leyendo
                            @elseif($book->pivot->estado == 'leido') ✅ Leído
                            @else 📖 Por leer @endif
                        </div>

                        <div class="puntuacion-patatas" style="margin-top: 5px;">
                            {{ str_repeat('🥔', $book->pivot->puntuacion ?? 0) }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="zona-vacia-estanteria" style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                    <span style="font-size: 3rem; opacity: 0.3;">📖</span>
                    <p>{{ $amigo->name }} aún no tiene libros en su estantería.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection