{{-- 1. PROTECCIÓN DE SEGURIDAD --}}
@if(!$user)
@php return; @endphp
@endif

<div class="patata-card-elegante shadow-sm">

    {{-- 🔍 Lógica de relación --}}
    @php
    $relacion = \App\Models\Amigo::where(function($q) use ($user) {
    $q->where('usuario_id', auth()->id())->where('amigo_id', $user->id);
    })->orWhere(function($q) use ($user) {
    $q->where('usuario_id', $user->id)->where('amigo_id', auth()->id());
    })->first();

    $esAmigoConfirmado = ($relacion && $relacion->estado == 'aceptada');
    // Detectamos si estamos en la pestaña de mis amigos para ocultar el texto
    $esPestanaMisAmigos = (request('tab') == 'mis-amigos');
    @endphp

    {{-- 🎯 BLOQUE SUPERIOR: Avatar (Clikeable si son amigos) --}}
    <div class="avatar-seccion">
        @if($esAmigoConfirmado)
        <a href="{{ route('amigos.visitar', $user->id) }}" class="enlace-perfil-patata">
            @endif

            <div class="avatar-completo-frame">
                <img src="{{ asset('img/avatar/base/' . basename($user->avatar_base ?? 'azulRelleno.png')) }}" class="avatar-layer" style="z-index: 1;">
                <img src="{{ asset('img/avatar/ojos/' . basename($user->avatar_ojos ?? 'ojos1.png')) }}" class="avatar-layer" style="z-index: 2;">
                <img src="{{ asset('img/avatar/boca/' . basename($user->avatar_boca ?? 'boca1.png')) }}" class="avatar-layer" style="z-index: 3;">
                @if($user->avatar_complemento)
                <img src="{{ asset('img/avatar/complemento/' . basename($user->avatar_complemento)) }}" class="avatar-layer" style="z-index: 4;">
                @endif
            </div>

            @if($esAmigoConfirmado)
        </a>
        @endif
    </div>

    {{-- 🏷️ INFO USUARIO: Nombre y libros pegados al avatar --}}
    <div class="info-usuario-container text-center" style="margin-top: -20px; position: relative; z-index: 10;">
        <h5 class="nombre-usuario" style="margin: 0; padding: 0; line-height: 0.9; font-weight: 800;">
            {{ $user->name }}
        </h5>

        <div class="badge-libros" style="font-size: 0.75rem; margin-top: 2px; opacity: 0.9;">
            📚 {{ $user->libros_count ?? 0 }} libros
        </div>

        @if($esAmigoConfirmado && !$esPestanaMisAmigos)
        <small class="txt-visitar" style="margin-top: 5px; display: inline-block;">
            Pulsar para visitar 🔍
        </small>
        @endif
    </div>

    {{-- 3. BLOQUE INFERIOR: Acciones (Footer) --}}
    <div class="footer-card">
        @if(isset($tipo) && $tipo == 'solicitud_recibida')
        {{-- Sección Solicitudes --}}
        <form action="{{ route('amigos.aceptar', $user->id) }}" method="POST" class="w-100">
            @csrf
            <button type="submit" class="btn-aceptar-v2">Aceptar</button>
        </form>
        <form action="{{ route('amigos.rechazar', $user->id) }}" method="POST" class="w-100">
            @csrf
            <button type="submit" class="btn-rechazar-v2">Rechazar solicitud</button>
        </form>

        @elseif($relacion)
        @if($relacion->estado == 'pendiente')
        <button class="btn-pendiente" style="width:100%; opacity:0.7;" disabled>⏳ Pendiente</button>
        @elseif($relacion->estado == 'aceptada')
        <div class="btn-amigos-confirmado">✅ ¡Amigos!</div>
        <form action="{{ route('amigos.eliminar', $user->id) }}" method="POST" onsubmit="return confirm('¿Eliminar amistad?')" class="w-100">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-eliminar-link">Eliminar amigo</button>
        </form>
        @endif
        @else
        {{-- Sección Descubrir --}}
        {{-- Sección Descubrir --}}
        <form action="{{ route('amigos.enviar', $user->id) }}" method="POST" class="w-100">
            @csrf
            {{-- CAMBIA LA CLASE AQUÍ: de btn-amigos-confirmado a btn-agregar-patata --}}
            <button type="submit" class="btn-agregar-amigo">Agregar</button>
        </form>
        @endif
    </div>
</div>