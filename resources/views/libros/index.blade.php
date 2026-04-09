@extends('plantilla.app')

@section('content')
<div class="seccion-auth">
    <div class="contenedor-menu-principal" style="padding-top: 20px;">

        {{-- 1. BUSCADOR HERO (Estilo buscador.css) --}}
        <div class="zona-busqueda-hero">
            <form action="{{ route('libros.buscar') }}" method="GET" id="form-busqueda" class="formulario-busqueda-gigante">
                <div class="input-wrapper-busqueda">
                    <input type="text" name="query" placeholder="Buscar libros..." value="{{ request('query') }}" required>
                    <button type="submit" id="btn-buscar" class="btn-buscar-estilo">🔍</button>
                </div>
            </form>
        </div>

        {{-- MENSAJE DE ÉXITO (Para sesiones tradicionales) --}}
        @if(session('success'))
        <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
            <div class="toast-exito">
                ✨ {{ session('success') }} 🥔
            </div>
        </div>
        @endif

        {{-- 2. LISTA DE RESULTADOS --}}
        @if(isset($libros) && count($libros) > 0)
        <div class="lista-resultados">
            @foreach($libros as $libro)
            @php
            $info = $libro['volumeInfo'] ?? null;
            $portada = $info['imageLinks']['thumbnail'] ?? asset('img/no-portada.png');
            $portada = str_replace('http://', 'https://', $portada);
            $titulo = $info['title'] ?? 'Sin título';
            $autor = isset($info['authors']) ? implode(', ', $info['authors']) : 'Autor desconocido';
            $genero = $info['categories'][0] ?? 'Ficción';
            @endphp

            <div class="tarjeta-libro-lista">
                {{-- Portada --}}
                <div style="flex-shrink: 0; margin-right: 25px;">
                    <img src="{{ $portada }}" class="portada-libro-resultado" style="width: 100px; height: 140px;">
                </div>

                {{-- Info --}}
                <div style="flex-grow: 1;">
                    <h3 class="auth-titulo" style="text-align: left; font-size: 1.3rem;">{{ Str::limit($titulo, 70) }}</h3>
                    <p class="auth-subtitulo" style="text-align: left;">{{ $autor }}</p>
                    <span class="etiqueta-genero">{{ $genero }}</span>
                </div>

                {{-- Acción (AJAX) --}}
                <div class="acciones-libro">
                    @auth
                    <button type="button"
                        class="btn-compacto-add"
                        onclick="añadirLibroSinRecargar(this)"
                        data-title="{{ $titulo }}"
                        data-author="{{ $autor }}"
                        data-genre="{{ $genero }}"
                        data-cover="{{ $portada }}">
                        + Añadir
                    </button>
                    @else
                    <button type="button" class="js-invitado btn-compacto-add" style="background: #9ca3af;">
                        + Añadir
                    </button>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>

        @elseif(request('query'))
        {{-- Estado vacío --}}
        <div class="busqueda-vacia" style="text-align: center; padding: 40px;">
            <p style="color: #8b5e3c; font-size: 1.2rem;">No hay patatas... digo, libros. 🥔</p>
            <a href="{{ route('libros.buscar') }}" class="btn-buscar-estilo" style="text-decoration: none; display: inline-block; margin-top: 15px;">
                ← Volver a intentar
            </a>
        </div>
        @endif

    </div>
</div>
@endsection