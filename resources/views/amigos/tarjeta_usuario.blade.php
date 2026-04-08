{{-- 1. PROTECCIÓN DE SEGURIDAD (Al principio del archivo) --}}
@if(!$user)
@php return; @endphp
@endif

<div class="patata-item-wrapper">
    <div class="patata-card-elegante shadow-sm">

        {{-- 1. El Avatar --}}
        <div class="avatar-completo-frame">
            <img src="{{ asset('img/avatar/base/' . basename($user->avatar_base ?? 'azulRelleno.png')) }}" class="avatar-layer" style="z-index: 1;">
            <img src="{{ asset('img/avatar/ojos/' . basename($user->avatar_ojos ?? 'ojos1.png')) }}" class="avatar-layer" style="z-index: 2;">
            <img src="{{ asset('img/avatar/boca/' . basename($user->avatar_boca ?? 'boca1.png')) }}" class="avatar-layer" style="z-index: 3;">
            @if($user->avatar_complemento)
            <img src="{{ asset('img/avatar/complemento/' . basename($user->avatar_complemento)) }}" class="avatar-layer" style="z-index: 4;">
            @endif
        </div>

        {{-- 2. Información del Usuario --}}
        <div class="info-usuario-container">
            <h5 class="nombre-usuario">{{ $user->name }}</h5>
            <div class="badge-libros">📚 {{ $user->libros_count ?? 0 }} libros</div>
        </div>

        {{-- 3. Acción Dinámica (LA PARTE QUE ME PREGUNTAS) --}}
        <div class="footer-card">

            {{-- BLOQUE NUEVO: Si la tarjeta está en la pestaña de Solicitudes Recibidas --}}
            @if(isset($tipo) && $tipo == 'solicitud_recibida')
            <div class="d-flex flex-column gap-2 w-100">
                <form action="{{ route('amigos.aceptar', $user->id) }}" method="POST" class="w-100">
                    @csrf
                    <button type="submit" class="btn-aceptar w-100">Aceptar</button>
                </form>
                <form action="{{ route('amigos.rechazar', $user->id) }}" method="POST" class="w-100">
                    @csrf
                    <button type="submit" class="btn-rechazar w-100 text-muted">Rechazar</button>
                </form>
            </div>

            {{-- BLOQUE NORMAL: Para las pestañas "Buscar" y "Mis Amigos" --}}
            @else
            @php
            $relacion = \App\Models\Amigo::where(function($q) use ($user) {
            $q->where('usuario_id', auth()->id())->where('amigo_id', $user->id);
            })->orWhere(function($q) use ($user) {
            $q->where('usuario_id', $user->id)->where('amigo_id', auth()->id());
            })->first();
            @endphp

            @if($relacion)
            @if($relacion->estado == 'pendiente')
            <button class="btn-pendiente" disabled>⏳ Pendiente</button>
            @else
            <div class="d-flex flex-column align-items-center gap-1">
                <button class="btn-amigos" disabled>✅ Amigo</button>
                <form action="{{ route('amigos.eliminar', $user->id) }}" method="POST"
                    onsubmit="return confirm('¿Dejar de ser amigo de {{ $user->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-eliminar-red">Eliminar amigo</button>
                </form>
            </div>
            @endif
            @else
            <form action="{{ route('amigos.enviar', $user->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn-agregar-amigo">➕ Agregar</button>
            </form>
            @endif
            @endif
        </div>
    </div>
</div>