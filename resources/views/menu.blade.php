@extends('plantilla.app')

@section('content')
<div class="contenedor-menu-principal">

    {{-- Título principal --}}
    <div class="caja-bienvenida">
        <h1 class="titulo-patata">¡Bienvenida a la Red de Patatas! 🥔</h1>
        @auth
        <p class="subtitulo-menu">Hola de nuevo, <strong>{{ Auth::user()->name }}</strong>. ¿Qué vamos a leer hoy?</p>
        @endauth

        @guest
        <div class="info-invitado">
            <p>¡Hola! <strong>Únete a la red</strong> para empezar a guardar tus libros.</p>
            <p class="detalle-invitado">Explora el mundo de la lectura. ¡Regístrate para guardar tus propios libros!</p>
        </div>
        @endguest
    </div>

    {{-- Grid de Tarjetas --}}
    <div class="grid-menu">

        @auth
        {{-- BLOQUE: Mi Biblioteca --}}
        <div class="tarjeta-menu">
            <div class="icono-tarjeta">📖</div>
            <h3>Mi Biblioteca</h3>
            <p>Gestiona tus lecturas guardadas.</p>
            <a href="{{ route('libros.estanteria') }}" class="btn-menu">Ver mis libros</a>
        </div>
        <div class="tarjeta-menu">
            <div class="icono-tarjeta">🏠</div>
            <h3>Concentración</h3>
            <p>Registra tu tiempo de concentracion.</p>
            <a href="{{ route('salas.index') }}" class="btn-menu">Ir a una sala</a>
        </div>

        <div class="tarjeta-menu">
            <div class="icono-tarjeta">🥔</div>
            <h3>Más patatas</h3>
            <p>Conoce más patatas.</p>
            <a href="{{ route('amigos.index') }}" class="btn-menu">Ver mas patatas</a>
        </div>


        @endauth

        {{-- BLOQUE: Explorar --}}
        <div class="tarjeta-menu">
            <div class="icono-tarjeta">🔍</div>
            <h3>Explorar</h3>
            <p>Busca nuevos libros en Google Books.</p>
            <a href="{{ route('libros.buscar') }}" class="btn-menu btn-oscuro">Buscar libros</a>
        </div>

        @guest
        {{-- BLOQUE: Registro --}}
        <div class="tarjeta-menu tarjeta-resaltada">
            <div class="icono-tarjeta">🥔</div>
            <h3>¡Únete!</h3>
            <p>Crea tu cuenta y personaliza tu patata.</p>
            <a href="{{ route('registro') }}" class="btn-menu">Registrarme</a>
        </div>
        @endguest

    </div>

    {{-- Datos Técnicos (Solo Auth) --}}
    @auth
    <details class="datos-tecnicos-avatar">
        <summary>Ver datos técnicos de mi avatar</summary>
        <div class="caja-datos-avatar">
            <p><strong>Cuerpo:</strong> {{ Auth::user()->avatar_base }}</p>
            <p><strong>Línea:</strong> {{ Auth::user()->avatar_linea }}</p>
            <p><strong>Ojos:</strong> {{ Auth::user()->avatar_ojos }}</p>
        </div>
    </details>
    @endauth

</div>
@endsection