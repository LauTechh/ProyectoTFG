@extends(Auth::check() ? 'plantilla.app' : 'plantilla.invitado')

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

        <div id="alerta-ajax" class="alerta-exito" style="display:none;">
            <p id="alerta-mensaje"></p>
        </div>

        <div class="lista-resultados">
            @forelse($libros as $libro)
            @php
            $info = $libro['volumeInfo'] ?? [];
            $portada = $info['imageLinks']['thumbnail'] ?? 'https://via.placeholder.com/150x225/f97316/ffffff?text=No+Cover';
            @endphp

            {{-- USAMOS TU CLASE COMPACTA --}}
            <div class="fila-libro-compacta">
                <img src="{{ $portada }}" class="portada-libro-resultado" alt="Portada">

                <div class="info-libro">
                    <h3>{{ $info['title'] ?? 'Sin título' }}</h3>
                    <p>{{ implode(', ', $info['authors'] ?? ['Desconocido']) }}</p>
                    <span class="etiqueta-genero">{{ $info['categories'][0] ?? 'Lectura' }}</span>
                </div>

                <div class="acciones-libro">
                    @auth
                    {{-- USAMOS TU BOTÓN COMPACTO --}}
                    <button class="btn-compacto-add" onclick="añadirLibroSinRecargar(this)"
                        data-title="{{ $info['title'] ?? '' }}"
                        data-author="{{ implode(', ', $info['authors'] ?? []) }}"
                        data-genre="{{ $info['categories'][0] ?? 'Lectura' }}"
                        data-cover="{{ $portada }}"
                        style="padding: 10px 20px; border: none; cursor: pointer;">
                        + Añadir
                    </button>
                    @else
                    <button class="btn-compacto-add" onclick="alertaInvitado()"
                        style="padding: 10px 20px; border: none; cursor: pointer;">
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