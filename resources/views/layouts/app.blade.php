<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patata Social Network</title>
    
    <link rel="icon" type="image/png" href="{{ asset('img/logo/logo_patata.png') }}">

    {{-- Cargamos los activos compilados (JS y CSS) una sola vez --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased {{ Auth::check() ? 'is-logged-in' : 'is-guest' }}"
    style="background-image: url('{{ Auth::check() ? asset('img/fondo/fondo2.png') : asset('img/fondo/fondo1.png') }}') !important; 
           background-size: cover !important; 
           background-attachment: fixed !important; 
           background-repeat: no-repeat !important; 
           background-color: transparent !important;">

    <nav class="main-nav">
        <div class="nav-left">
            {{-- Usamos route('home') para que siempre vuelva al inicio correctamente --}}
            <a href="{{ route('home') }}" class="nav-logo">
                <img src="{{ asset('img/logo/logo_patata.png') }}" alt="Logo Patata Social Network" class="logo-img">
            </a>
        </div>

        <div class="nav-right">
            @auth
            <a href="{{ route('perfil') }}" class="nav-profile-link" style="display: flex; align-items: center; gap: 12px; text-decoration: none; color: inherit;">

                <div class="avatar-circle">
                    {{-- Capa 1: Base de la Patata --}}
                    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_base) }}" class="avatar-layer layer-base">

                    {{-- Capa 2: Boca --}}
                    @if(Auth::user()->avatar_boca)
                    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_boca) }}" class="avatar-layer layer-boca">
                    @endif

                    {{-- Capa 3: Ojos --}}
                    @if(Auth::user()->avatar_ojos)
                    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_ojos) }}" class="avatar-layer layer-ojos">
                    @endif

                    {{-- Capa 4: Complemento --}}
                    @if(Auth::user()->avatar_complemento)
                    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_complemento) }}" class="avatar-layer layer-complement">
                    @endif
                </div>

                <span class="user-name" style="font-weight: bold; color: #333;">{{ Auth::user()->name }}</span>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="logout-form" style="margin-left: 10px;">
                @csrf
                <button type="submit" class="btn-logout">Salir</button>
            </form>
            @endauth

            @guest
            <a href="{{ route('login') }}" class="link-login">Entrar</a>
            <a href="{{ route('registro') }}" class="btn-join">Unirse</a>
            @endguest
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

</body>
</html>