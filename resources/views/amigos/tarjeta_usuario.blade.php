{{-- 1. PROTECCIÓN DE SEGURIDAD --}}
@if(!$user)
@php return; @endphp
@endif

<div class="patata-item-wrapper">
    <div class="patata-card-elegante shadow-sm">

        {{-- 🔍 Lógica para determinar el estado de la relación --}}
        @php
        $relacion = \App\Models\Amigo::where(function($q) use ($user) {
        $q->where('usuario_id', auth()->id())->where('amigo_id', $user->id);
        })->orWhere(function($q) use ($user) {
        $q->where('usuario_id', $user->id)->where('amigo_id', auth()->id());
        })->first();

        $esAmigoConfirmado = ($relacion && $relacion->estado == 'aceptada');
        @endphp

        {{-- 🎯 ENLACE AL PERFIL: Solo si son amigos confirmados --}}
        @if($esAmigoConfirmado)
        <a href="{{ route('amigos.visitar', $user->id) }}" style="text-decoration: none; color: inherit; display: block;">
            @endif

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
            <div class="info-usuario-container text-center">
                <h5 class="nombre-usuario" style="margin-bottom: 5px;">{{ $user->name }}</h5>
                <div class="badge-libros">📚 {{ $user->libros_count ?? 0 }} libros</div>

                @if($esAmigoConfirmado)
                <small style="color: #b87333; font-size: 0.65rem; font-weight: bold; display: block; margin-top: 5px;">
                    Pulsar para visitar 🔍
                </small>
                @endif
            </div>

            @if($esAmigoConfirmado)
        </a>
        @endif

        {{-- 3. Acción Dinámica (Fuera del enlace para no romper los botones) --}}
        <div class="footer-card" style="margin-top: 15px;">

            {{-- CASO A: Solicitudes Recibidas --}}
            @if(isset($tipo) && $tipo == 'solicitud_recibida')
            <div class="d-flex flex-column gap-2 w-100">
                <form action="{{ route('amigos.aceptar', $user->id) }}" method="POST" class="w-100">
                    @csrf
                    <button type="submit" class="btn-aceptar w-100">Aceptar</button>
                </form>
                <form action="{{ route('amigos.rechazar', $user->id) }}" method="POST" class="w-100">
                    @csrf
                    <button type="submit" class="btn-rechazar w-100 text-muted" style="font-size: 0.8rem; background: none; border: none;">Rechazar</button>
                </form>
            </div>

            {{-- CASO B: Buscar y Mis Amigos --}}
            @else
            @if($relacion)
            @if($relacion->estado == 'pendiente')
            <button class="btn-pendiente w-100" disabled style="opacity: 0.7;">⏳ Pendiente</button>
            @else
            {{-- Ya son amigos (Confirmado) --}}
            <div class="d-flex flex-column align-items-center gap-1 w-100">
                <button class="btn-amigos w-100" disabled style="background: #ecfdf5; color: #059669; border: 1px solid #10b981;">✅ Amigo</button>

                <form action="{{ route('amigos.eliminar', $user->id) }}" method="POST"
                    onsubmit="return confirm('¿Dejar de ser amigo de {{ $user->name }}?')" class="w-100">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-eliminar-red w-100" style="font-size: 0.7rem; color: #dc2626; background: none; border: none; margin-top: 5px;">
                        Eliminar amigo
                    </button>
                </form>
            </div>
            @endif
            @else
            {{-- No hay relación: Botón Agregar --}}
            <form action="{{ route('amigos.enviar', $user->id) }}" method="POST" class="w-100">
                @csrf
                <button type="submit" class="btn-agregar-amigo w-100">➕ Agregar</button>
            </form>
            @endif
            @endif
        </div>
    </div>
</div>