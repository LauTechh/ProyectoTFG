@extends(Auth::check() ? 'plantilla.app' : 'plantilla.invitado')

@section('content')
<section class="seccion-auth"> {{-- Reutilizamos tu centrador de Auth --}}
    <div class="contenedor-auth-card"> {{-- La tarjeta beige que ya tienes definida --}}

        <h1 class="titulo-invitado">🥔 Resultados para: {{ request('query') }}</h1>

        <div class="enlace-volver">
            <a href="{{ route('libros.estanteria') }}">← Ir a mi estantería</a>
        </div>

        <div class="lista-resultados"> {{-- Clase de tu CSS para dar aire --}}
            @forelse($libros as $libro)
            @php
            $info = $libro['volumeInfo'];
            $portada = $info['imageLinks']['thumbnail'] ?? asset('img/no-portada.png');
            @endphp

            <div class="fila-libro"> {{-- Tu tarjeta blanca con hover --}}
                <img src="{{ $portada }}" class="portada-libro-resultado">

                <div class="info-libro">
                    <h3>{{ $info['title'] ?? 'Sin título' }}</h3>
                    <p>{{ implode(', ', $info['authors'] ?? ['Autor desconocido']) }}</p>
                    <span class="etiqueta-genero">{{ $info['categories'][0] ?? 'Lectura' }}</span>
                </div>

                <div class="acciones-libro">
                    @auth
                    <button class="btn-compacto-add btn-añadir-libro"
                        onclick="añadirLibroSinRecargar(this)"
                        data-title="{{ $info['title'] ?? '' }}"
                        data-author="{{ implode(', ', $info['authors'] ?? []) }}"
                        data-cover="{{ $portada }}">
                        + Añadir
                    </button>
                    @endauth
                </div>
            </div>
            @empty
            <p>No hay patatas... digo, libros. 🥔</p>
            @endforelse
        </div>

        <div class="enlace-volver">
            <a href="/">← Volver al inicio</a>
        </div>
    </div>
</section>
@endsection