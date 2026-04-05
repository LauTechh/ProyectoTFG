<nav class="nav-principal">
    {{-- LADO IZQUIERDO: LOGO --}}
    <div class="nav-left">
        <a href="{{ route('home') }}" class="nav-logo">
            <img src="{{ asset('img/logo/logo_patata.png') }}" alt="Logo Patata Social Network" class="logo-nav-img">
        </a>
    </div>

    {{-- LADO DERECHO: BUSCADOR + ACCIONES --}}
    <div class="nav-derecha" style="display: flex; align-items: center; gap: 20px;">

        {{-- 🔍 BUSCADOR GLOBAL --}}
        <form action="{{ route('libros.buscar') }}" method="GET" class="formulario-busqueda-nav" style="margin: 0;">
            <div style="position: relative; display: flex; align-items: center;">
                <input type="text" name="query"
                    placeholder="Buscar libros..."
                    style="padding: 8px 35px 8px 15px; border-radius: 20px; border: 2px solid #ffedd5; background-color: #fffaf5; font-size: 0.9em; outline: none; width: 180px;"
                    required>
                <button type="submit" style="position: absolute; right: 10px; background: none; border: none; cursor: pointer; color: #fb923c; display: flex; align-items: center;">
                    <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </form>

        {{-- 🌟 SECCIÓN PARA USUARIOS LOGUEADOS 🌟 --}}
        @auth
        {{-- 1. Enlace al Perfil (Cambiado a enlace-perfil-nav) --}}
        <a href="{{ route('perfil') }}" class="enlace-perfil-nav" style="display: flex; align-items: center; gap: 12px; text-decoration: none; color: inherit;">
            <div class="circulo-avatar">
                <img src="{{ asset('img/avatar/' . Auth::user()->avatar_base) }}" class="capa-avatar capa-base">
                @if(Auth::user()->avatar_boca)
                <img src="{{ asset('img/avatar/' . Auth::user()->avatar_boca) }}" class="capa-avatar capa-boca">
                @endif
                @if(Auth::user()->avatar_ojos)
                <img src="{{ asset('img/avatar/' . Auth::user()->avatar_ojos) }}" class="capa-avatar capa-ojos">
                @endif
                @if(Auth::user()->avatar_complemento)
                <img src="{{ asset('img/avatar/' . Auth::user()->avatar_complemento) }}" class="capa-avatar capa-complemento">
                @endif
            </div>
            <span class="user-name" style="font-weight: bold; color: #333;">{{ Auth::user()->name }}</span>
        </a>

        {{-- 2. Logout --}}
        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" style="background: #751d1d; color: white; border: none; padding: 7px 18px; border-radius: 20px; font-weight: bold; cursor: pointer; transition: 0.2s;">
                Salir
            </button>
        </form>
        @endauth

        {{-- 🌟 SECCIÓN PARA INVITADOS 🌟 --}}
        @guest
        <div style="display: flex; align-items: center; gap: 10px;">
            <a href="{{ route('login') }}" style="text-decoration: none; color: #5d4037; font-weight: bold; font-size: 0.95rem;">
                Entrar
            </a>
            <a href="{{ route('registro') }}" style="text-decoration: none; background: #fb923c; color: white; padding: 9px 22px; border-radius: 20px; font-weight: bold; box-shadow: 0 4px 10px rgba(251, 146, 60, 0.2); transition: 0.2s;">
                Unirse
            </a>
        </div>
        @endguest

    </div>
</nav>