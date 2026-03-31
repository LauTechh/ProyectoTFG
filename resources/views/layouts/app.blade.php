<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patata Social Network</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="main-nav">
        @auth
            <a href="/perfil" class="nav-profile-link">
                <div class="avatar-circle">
                    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_base) }}" class="avatar-layer layer-base">
                    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_linea) }}" class="avatar-layer layer-multiply">
                    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_ojos) }}" class="avatar-layer layer-eyes">
                </div>
                <span class="user-name">{{ Auth::user()->name }}</span>
            </a>
            
            <a href="/menu" class="btn">Menú Principal</a>

            <form action="/logout" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Cerrar sesión</button>
            </form>
        @endauth

        @guest
            <a href="/login" class="btn">Inicia sesión</a>
            <a href="/registro" class="btn btn-dark">Crear cuenta</a>
        @endguest
    </nav>

    <main class="container">
        @yield('content')
    </main>
</body>
</html>