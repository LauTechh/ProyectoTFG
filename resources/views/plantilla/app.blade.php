<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('meta')

    <title>Patata Social Network</title>

    {{-- Icono de la web --}}
    <link rel="icon" type="image/png" href="{{ asset('img/logo/logo_patata.png') }}">

    {{-- Cargamos los activos con Vite (Solo una vez) --}}
    {{-- Cargamos los tres activos con Vite --}}
    @vite([
    'resources/css/app.css',
    'resources/css/componentes/libros.css',
    'resources/css/componentes/estanteria.css',
    'resources/js/app.js'
    ])
    {{-- Si 'fix-list.css' es importante, lo ideal es que lo metas en resources/css 
         y lo añadas al array de Vite arriba. Si no, déjalo aquí abajo: --}}
    @if(file_exists(public_path('css/fix-list.css')))
    <link rel="stylesheet" href="{{ asset('css/fix-list.css') }}">
    @endif
</head>

<body class="antialiased {{ Auth::check() ? 'esta-logueado' : 'es-invitado' }}"
    style="background-image: url('{{ Auth::check() ? asset('img/fondo/fondo2.png') : asset('img/fondo/fondo1.png') }}') !important; 
           background-size: cover !important; 
           background-attachment: fixed !important; 
           background-repeat: no-repeat !important; 
           background-color: transparent !important;">

    {{-- Llamada a la nueva carpeta 'componentes' --}}
    @include('componentes.nav')

    <main class="diseño-contenido-principal">
        @yield('content')
    </main>

</body>

</html>