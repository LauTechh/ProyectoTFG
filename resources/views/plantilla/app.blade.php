<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- 1. Metadatos de seguridad y rutas --}}
    @yield('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="route-guardar-libro" content="{{ route('libros.guardar') }}">

    <title>Patata Social Network</title>

    {{-- Icono de la web --}}
    <link rel="icon" type="image/png" href="{{ asset('img/logo/logo_patata.png') }}">

    {{-- 2. Activos con Vite --}}
    @vite([
    'resources/css/app.css',
    'resources/css/componentes/libros.css',
    'resources/css/componentes/estanteria.css',
    'resources/css/componentes/salas.css',
    'resources/js/app.js'
    ])

    @if(file_exists(public_path('css/fix-list.css')))
    <link rel="stylesheet" href="{{ asset('css/fix-list.css') }}">
    @endif
</head>

<body class="antialiased {{ Auth::check() ? 'esta-logueado' : 'es-invitado' }}"
    data-sala="@yield('clase-body', 'otra')"
    style="background-image: url('{{ Auth::check() ? asset('img/fondo/fondo2.png') : asset('img/fondo/fondo1.png') }}') !important; 
           background-size: cover !important; 
           background-attachment: fixed !important; 
           background-repeat: no-repeat !important; 
           background-color: transparent !important;">

    {{-- Nav principal --}}
    @include('componentes.nav')

    {{-- 🥔 Aquí incluimos el componente de alertas (éxito, error y ajax) --}}
    @include('componentes.alertas')

    {{-- Contenido principal --}}
    <main class="diseño-contenido-principal">
        @yield('content')
    </main>

    {{-- Script del Cronómetro Automático --}}
    @auth
    
    @endauth

</body>

</html>