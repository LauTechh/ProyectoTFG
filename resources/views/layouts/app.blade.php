<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patata Social Network</title>

    <link rel="icon" type="image/png" href="{{ asset('img/logo/logo_patata.png') }}">

    {{-- Cargamos los activos compilados (JS y CSS) una sola vez --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/fix-list.css') }}"> {{-- O añádelo al array de Vite --}}
</head>

<body class="antialiased {{ Auth::check() ? 'is-logged-in' : 'is-guest' }}"
    style="background-image: url('{{ Auth::check() ? asset('img/fondo/fondo2.png') : asset('img/fondo/fondo1.png') }}') !important; 
           background-size: cover !important; 
           background-attachment: fixed !important; 
           background-repeat: no-repeat !important; 
           background-color: transparent !important;">

    @include('partials.nav')

    <main class="main-content-layout"> {{-- Hemos cambiado 'container' por esta nueva clase --}}
        @yield('content')
    </main>

</body>

</html>