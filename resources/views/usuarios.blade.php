@extends('plantilla.app')

@section('content')
{{-- Cargamos tus estilos de perfil para heredar la estructura de 1/3 y 2/3 --}}
@vite(['resources/css/perfil.css'])
{{-- Y tu nuevo CSS específico para la lista --}}
<link rel="stylesheet" href="{{ asset('css/componentes/lista-usuarios.css') }}">

<div class="text-center mb-4" style="margin-top: 20px;">
    <h1 class="display-5 fw-bold text-dark">Más patatas en Patatas y Letras</h1>
</div>

<div class="contenedor-perfil-layout">

    {{-- COLUMNA IZQUIERDA (1/3): NAVEGACIÓN --}}
    <div class="columna-perfil-izq">
        <div class="tarjeta-decorativa shadow-sm">
            <div class="cuerpo-tarjeta-navegacion">
                <h3 class="libro-titulo-compacto">Navegación</h3>

                <div class="grupo-botones-vertical">
                    <a href="/" class="btn-perfil-navegacion">🏠 Inicio</a>
                    <a href="{{ route('libros.estanteria') }}" class="btn-perfil-navegacion">📚 Mi Estantería</a>
                    <a href="/perfil" class="btn-perfil-navegacion">🥔 Mi Perfil</a>
                    <a href="/buscar-amigos" class="btn-perfil-navegacion active" style="background-color: #fed7aa;">👥 Buscar Amigos</a>
                </div>

                <hr class="separador-perfil">

                <p class="txt-decorativo">
                    "Las patatas que leen juntas, permanecen juntas."
                </p>
            </div>
        </div>
    </div>

    {{-- COLUMNA DERECHA (2/3): LISTA DE USUARIOS --}}
    <div class="columna-perfil-der">
        {{-- Contenedor interno para que las patatas salgan en 2 columnas --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            
            @foreach($usuarios as $user)
                <div class="card patata-card shadow-sm p-4 text-center" style="background: white; border-radius: 20px; border: none; margin-top: 40px;">
                    
                    <div class="avatar-completo-frame" style="position: relative; width: 100px; height: 100px; margin: -55px auto 10px auto;">
                        <img src="{{ asset('img/avatar/base/' . basename($user->avatar_base ?? 'azulRelleno.png')) }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; z-index: 1;">
                        <img src="{{ asset('img/avatar/ojos/' . basename($user->avatar_ojos ?? 'ojos1.png')) }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; z-index: 2;">
                        <img src="{{ asset('img/avatar/boca/' . basename($user->avatar_boca ?? 'boca1.png')) }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; z-index: 3;">
                        @if($user->avatar_complemento)
                            <img src="{{ asset('img/avatar/complemento/' . basename($user->avatar_complemento)) }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; z-index: 4;">
                        @endif
                    </div>

                    <h5 class="fw-bold mb-1" style="font-size: 1.1rem;">{{ $user->name }}</h5>
                    <p class="text-muted small">
                        {{ $user->libros_count ?? 0 }} libros en estantería
                    </p>

                    <div class="mt-3 pt-2 border-top">
                        <button class="btn-compacto-add" style="width: 100%; border-radius: 20px;">➕ Agregar</button>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

</div>
@endsection