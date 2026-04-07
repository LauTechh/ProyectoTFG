@extends('plantilla.app')

@section('content')
@vite(['resources/css/componentes/lista-usuarios.css'])

<div class="titulo-crema">
    <h1 class="display-5 fw-bold text-dark">Más patatas en Patatas y Letras</h1>
    <p class="text-muted">Encuentra nuevos amigos para compartir lecturas</p>
</div>

<div class="contenedor-perfil-layout">

    {{-- COLUMNA IZQUIERDA (1/3) --}}
    <div class="columna-perfil-izq">
        <div class="tarjeta-navegacion-fija shadow-sm">
            <h3 class="titulo-menu">Navegación</h3>
            <div class="grupo-botones-vertical">
                <a href="/" class="btn-nav">🏠 Inicio</a>
                <a href="{{ route('libros.estanteria') }}" class="btn-nav">📚 Mi Estantería</a>
                <a href="/perfil" class="btn-nav">🥔 Mi Perfil</a>
                <a href="/buscar-amigos" class="btn-nav active">👥 Buscar Amigos</a>
            </div>
            <hr class="separador-menu">
            <p class="cita-decorativa">"Las patatas que leen juntas, permanecen juntas."</p>
        </div>
    </div>

    {{-- COLUMNA DERECHA (2/3) --}}
    {{-- PANEL DERECHO: LA ZONA DE LAS PATATAS --}}
    <div class="columna-perfil-der">

        {{-- El contenedor del GRID solo se escribe UNA VEZ --}}
        <div class="grid-usuarios-container">

            @foreach($usuarios as $user)
            {{-- CADA USUARIO TIENE SU PROPIO DIV ENVOLVENTE (patata-item-wrapper) --}}
            <div class="patata-item-wrapper">
                <div class="patata-card-elegante shadow-sm">

                    {{-- 1. El Avatar --}}
                    <div class="avatar-completo-frame">
                        <img src="{{ asset('img/avatar/base/' . basename($user->avatar_base ?? 'azulRelleno.png')) }}" class="avatar-layer" style="z-index: 1;">
                        <img src="{{ asset('img/avatar/ojos/' . basename($user->avatar_ojos ?? 'ojos1.png')) }}" class="avatar-layer" style="z-index: 2;">
                        <img src="{{ asset('img/avatar/boca/' . basename($user->avatar_boca ?? 'boca1.png')) }}" class="avatar-layer" style="z-index: 3;">
                        @if($user->avatar_complemento)
                        <img src="{{ asset('img/avatar/complemento/' . basename($user->avatar_complemento)) }}" class="avatar-layer" style="z-index: 4;">
                        @endif
                    </div>

                    {{-- 2. Las Características (Info) --}}
                    <div class="info-usuario-container">
                        <h5 class="nombre-usuario">{{ $user->name }}</h5>
                        <div class="badge-libros">
                            📚 {{ $user->libros_count ?? 0 }} libros
                        </div>
                        <p class="text-muted small mt-2">Amante de las patatas y las letras</p>
                    </div>

                    {{-- 3. Acción --}}
                    <div class="footer-card">
                        <button class="btn-agregar-amigo">➕ Agregar</button>
                    </div>
                </div>
            </div>
            @endforeach

        </div> {{-- Fin del grid --}}
    </div>
</div>
@endsection