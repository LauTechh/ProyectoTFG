<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patata Social Network</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <nav class="main-nav" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 30px;">
        <div class="nav-left">
            <a href="{{ Auth::check() ? '/menu' : '/' }}" style="text-decoration: none; font-size: 1.5rem;">🥔 <span style="font-weight: bold; color: #333;">Libros</span></a>
        </div>

        <div class="nav-right" style="display: flex; align-items: center; gap: 20px;">
            @auth
            <a href="/perfil" class="nav-profile-link" style="text-decoration: none; display: flex; align-items: center; gap: 10px;">
                <div class="avatar-circle" style="width: 40px; height: 40px;">
                    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_base) }}" class="avatar-layer layer-base">
                    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_linea) }}" class="avatar-layer layer-multiply">
                    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_ojos) }}" class="avatar-layer layer-eyes">
                </div>
                <span class="user-name" style="font-weight: 600; color: #555;">{{ Auth::user()->name }}</span>
            </a>

            <form action="/logout" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="background: #fee2e2; color: #ef4444; border: none; padding: 8px 15px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 0.9rem;">
                    Salir
                </button>
            </form>
            @endauth

            @guest
            <a href="/login" style="text-decoration: none; color: #666; font-weight: 600;">Entrar</a>
            <a href="/registro" style="text-decoration: none; background: #333; color: white; padding: 8px 15px; border-radius: 8px; font-weight: 600;">Unirse</a>
            @endguest
        </div>
    </nav>

    <main class="container"> @yield('content')
    </main>
</body>

</html>