<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Patata Social Network</title>

    {{-- Cargamos EXACTAMENTE los mismos activos que en app.blade.php --}}
    @vite([
    'resources/css/app.css',
    'resources/css/componentes/libros.css',
    'resources/css/componentes/estanteria.css',
    'resources/js/app.js'
    ])
</head>

<body class="antialiased es-invitado"
    style="background-image: url('{{ asset('img/fondo/fondo1.png') }}') !important; 
           background-size: cover !important; 
           background-attachment: fixed !important; 
           background-repeat: no-repeat !important;">

    @include('componentes.nav')

    {{-- Usamos la misma clase que en app.blade.php para que el CSS se aplique igual --}}
    <main class="diseño-contenido-principal">
        @yield('content')
    </main>

</body>

</html>