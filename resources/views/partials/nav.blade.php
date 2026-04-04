<nav class="main-nav">
    <div class="nav-left">
        <a href="{{ route('home') }}" class="nav-logo">
            <img src="{{ asset('img/logo/logo_patata.png') }}" alt="Logo Patata Social Network" class="logo-img">
        </a>
    </div>

    <div class="nav-right">
        @auth
            {{-- 1. Buscador Global --}}
            <form action="{{ route('books.search') }}" method="GET" style="margin-right: 20px;">
                <div style="position: relative; display: flex; align-items: center;">
                    <input type="text" name="query"
                        placeholder="Buscar libros..."
                        style="padding: 6px 35px 6px 15px; border-radius: 20px; border: 2px solid #ffedd5; background-color: #fffaf5; font-size: 0.9em; outline: none; width: 180px;"
                        required>
                    <button type="submit" style="position: absolute; right: 10px; background: none; border: none; cursor: pointer; color: #fb923c;">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>

            {{-- 2. Enlace al Perfil con Avatar de Capas --}}
            <a href="{{ route('perfil') }}" class="nav-profile-link" style="display: flex; align-items: center; gap: 12px; text-decoration: none; color: inherit;">
                <div class="avatar-circle">
                    {{-- Capa 1: Base --}}
                    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_base) }}" class="avatar-layer layer-base">

                    {{-- Capas condicionales --}}
                    @if(Auth::user()->avatar_boca)
                        <img src="{{ asset('img/avatar/' . Auth::user()->avatar_boca) }}" class="avatar-layer layer-boca">
                    @endif

                    @if(Auth::user()->avatar_ojos)
                        <img src="{{ asset('img/avatar/' . Auth::user()->avatar_ojos) }}" class="avatar-layer layer-ojos">
                    @endif

                    @if(Auth::user()->avatar_complemento)
                        <img src="{{ asset('img/avatar/' . Auth::user()->avatar_complemento) }}" class="avatar-layer layer-complement">
                    @endif
                </div>
                <span class="user-name" style="font-weight: bold; color: #333;">{{ Auth::user()->name }}</span>
            </a>

            {{-- 3. Logout --}}
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