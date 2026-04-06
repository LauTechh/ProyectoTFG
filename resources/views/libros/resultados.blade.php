@extends(Auth::check() ? 'plantilla.app' : 'plantilla.invitado')

{{-- 1. Los "Metadatos" para que el JS sepa qué hacer --}}
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="route-guardar-libro" content="{{ route('libros.guardar') }}">
@endsection

@section('content')
<div class="contenedor-perfil-layout">
    <div class="columna-perfil-der">

        <h2 class="auth-titulo">Resultados para: {{ request('query') }}</h2>

        <div class="buscador-seccion-resultados">
            <form action="{{ route('libros.buscar') }}" method="GET" class="buscador-flex">
                <input type="text" name="query" value="{{ request('query') }}" placeholder="Busca otro libro..." class="auth-input">
                <button type="submit" class="btn-primario">🔍 Buscar</button>
            </form>
        </div>

        {{-- Alerta AJAX (Invisible por defecto) --}}
        <div id="alerta-ajax" class="alerta-exito" style="display:none;">
            <p id="alerta-mensaje"></p>
        </div>

        <div class="lista-resultados">
            @forelse($libros as $libro)
            @php
            $info = $libro['volumeInfo'] ?? [];
            $portada = $info['imageLinks']['thumbnail'] ?? 'https://via.placeholder.com/150x225/f97316/ffffff?text=No+Cover';
            @endphp

            <div class="fila-libro">
                <img src="{{ $portada }}" class="portada-libro-resultado" alt="Portada">

                <div class="info-libro">
                    <h3>{{ $info['title'] ?? 'Sin título' }}</h3>
                    <p>{{ implode(', ', $info['authors'] ?? ['Desconocido']) }}</p>
                    <span class="etiqueta-genero">{{ $info['categories'][0] ?? 'Lectura' }}</span>
                </div>

                <div class="acciones-libro">
                    @auth
                    <button class="btn-primario" onclick="añadirLibroSinRecargar(this)"
                        data-title="{{ $info['title'] ?? '' }}"
                        data-author="{{ implode(', ', $info['authors'] ?? []) }}"
                        data-genre="{{ $info['categories'][0] ?? 'Lectura' }}"
                        data-cover="{{ $portada }}">
                        + Añadir
                    </button>
                    @else
                    <button class="btn-primario" onclick="alertaInvitado()">
                        + Añadir
                    </button>
                    @endauth
                </div>
            </div>
            @empty
            <p class="auth-subtitulo">No hay resultados para esa patata. 🥔💨</p>
            @endforelse
        </div>
    </div>
</div>
@endsection