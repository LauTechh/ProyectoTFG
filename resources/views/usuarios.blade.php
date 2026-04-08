@extends('plantilla.app')

@section('content')
@vite(['resources/css/componentes/lista-usuarios.css'])


@if(session('success'))
<div class="alerta-patata-exitosa">
    {{ session('success') }}
</div>
@endif



<div class="titulo-crema">
    <h1 class="display-5 fw-bold text-dark">Más patatas en Patatas y Letras</h1>
    <p class="text-muted">Encuentra nuevos amigos para compartir lecturas</p>
</div>



<div class="contenedor-perfil-layout">

    {{-- COLUMNA IZQUIERDA (1/3) --}}
    <div class="columna-perfil-izq">
        <div class="tarjeta-navegacion-fija shadow-sm">
            <h3 class="titulo-menu">Amistades</h3>
            <div class="grupo-botones-vertical">
                {{-- Botón para buscar patatas nuevas --}}
                <a href="{{ route('amigos.index', ['tab' => 'buscar']) }}"
                    class="btn-nav {{ request('tab') != 'mis-amigos' ? 'active' : '' }}">
                    🔎 Más patatas
                </a>

                {{-- Botón para ver tus amigos y solicitudes --}}
                {{-- 2. Mis Amigos --}}
                <a href="{{ route('amigos.index', ['tab' => 'mis-amigos']) }}"
                    class="btn-nav {{ request('tab') == 'mis-amigos' ? 'active' : '' }}">
                    👥 Mis amigos
                </a>

                {{-- 3. SOLICITUDES (Aquí es donde ponemos el contador) --}}
                <a href="{{ route('amigos.index', ['tab' => 'solicitudes']) }}"
                    class="btn-nav {{ request('tab') == 'solicitudes' ? 'active' : '' }} d-flex justify-content-between align-items-center">
                    <span>🔔 Solicitudes</span>

                    @if($solicitudesPendientes > 0)
                    <span class="badge-notificacion">{{ $solicitudesPendientes }}</span>
                    @endif
                </a>
            </div>
            <hr class="separador-menu">
            <a href="/" class="btn-nav">🏠 Volver al inicio</a>
        </div>
    </div>



    {{-- COLUMNA DERECHA (2/3) --}}
    {{-- PANEL DERECHO: LA ZONA DE LAS PATATAS --}}
    {{-- COLUMNA DERECHA (2/3) --}}
    <div class="columna-perfil-der">

        {{-- CASO 1: PESTAÑA DE SOLICITUDES (Buzón de entrada) --}}
        @if(request('tab') == 'solicitudes')
        <h3 class="mb-4">🔔 Solicitudes recibidas</h3>

        @php
        // Añadimos ->with('sender') para traer los datos del usuario de golpe y evitar errores
        $solicitudesRecibidas = \App\Models\Amigo::where('amigo_id', auth()->id())
        ->where('estado', 'pendiente')
        ->with('sender')
        ->get();
        @endphp

        @if($solicitudesRecibidas->count() > 0)
        <div class="grid-usuarios-container">
            @foreach($solicitudesRecibidas as $soli)
            {{-- Verificamos que el sender exista antes de incluir la tarjeta --}}
            @if($soli->sender)
            @include('amigos.tarjeta_usuario', [
            'user' => $soli->sender,
            'tipo' => 'solicitud_recibida'
            ])
            @endif
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <p class="text-muted">No tienes ninguna solicitud pendiente de aceptar. 🥔</p>
        </div>
        @endif

        {{-- CASO 2: PESTAÑA DE MIS AMIGOS (Confirmados y enviados por ti) --}}
        @elseif(request('tab') == 'mis-amigos')
        <h3 class="mb-4">Mis amigos patatiles</h3>
        <div class="grid-usuarios-container">
            @forelse($misAmigos as $user)
            @include('amigos.tarjeta_usuario', ['user' => $user, 'tipo' => 'gestion'])
            @empty
            <div class="text-center py-5">
                <p class="text-muted">Aún no tienes amigos confirmados ni solicitudes enviadas.</p>
            </div>
            @endforelse
        </div>

        {{-- CASO 3: VISTA DE BUSCAR (POR DEFECTO) --}}
        @else
        <h3 class="mb-4">Descubrir nuevas patatas</h3>
        <div class="grid-usuarios-container">
            @foreach($usuarios as $user)
            @include('amigos.tarjeta_usuario', ['user' => $user, 'tipo' => 'buscar'])
            @endforeach
        </div>
        @endif

    </div>
</div>
@endsection