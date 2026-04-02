<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patata Social Network</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- Mantenemos las clases dinámicas para el fondo --}}
<body class="antialiased {{ Auth::check() ? 'is-logged-in' : 'is-guest' }}" 
      style="background-image: url('{{ Auth::check() ? asset('img/fondo/fondo2.png') : asset('img/fondo/fondo1.png') }}') !important; 
             background-size: cover !important; 
             background-attachment: fixed !important; 
             background-repeat: no-repeat !important; 
             background-color: transparent !important;">    
    <nav class="main-nav">
        <div class="nav-left">
            {{-- CAMBIO AQUÍ: Eliminamos el '/menu' que no existe y ponemos solo '/' --}}
            <a href="/" class="nav-logo">
                🥔 <span class="logo-text">Libros</span>
            </a>
        </div>

        <div class="nav-right">
            @auth
            <a href="/perfil" class="nav-profile-link">
                <div class="avatar-circle">
                    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_base) }}" class="avatar-layer layer-base">
                    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_linea) }}" class="avatar-layer layer-multiply">
                    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_ojos) }}" class="avatar-layer layer-eyes">
                </div>
                <span class="user-name">{{ Auth::user()->name }}</span>
            </a>

            <form action="/logout" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="btn-logout">Salir</button>
            </form>
            @endauth

            @guest
            <a href="/login" class="link-login">Entrar</a>
            <a href="/registro" class="btn-join">Unirse</a>
            @endguest
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>
</body>

</html>