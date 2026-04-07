@extends('plantilla.app')

@section('content')
<div class="contenedor-menu-principal">
    <div class="caja-bienvenida">
        <h1 class="titulo-patata">Salas de Concentración ⏱️</h1>
        <p>Selecciona un ambiente para empezar tu sesión de estudio.</p>
    </div>

    <div class="grid-salas">
        {{-- Sala 1 --}}
        <a href="{{ route('salas.show', 'despacho-rosa') }}" class="tarjeta-sala">
            <div class="emoji-sala">🌸</div>
            <h3>Despacho Rosa</h3>
            <p>Un ambiente dulce y tranquilo.</p>
        </a>

        {{-- Sala 2 --}}
        <a href="{{ route('salas.show', 'biblioteca') }}" class="tarjeta-sala">
            <div class="emoji-sala">📚</div>
            <h3>Biblioteca</h3>
            <p>Silencio absoluto entre libros.</p>
        </a>

        {{-- Sala 3 --}}
        <a href="{{ route('salas.show', 'dormitorio') }}" class="tarjeta-sala">
            <div class="emoji-sala">🛏️</div>
            <h3>Dormitorio</h3>
            <p>Para un estudio más relajado.</p>
        </a>

        {{-- Sala 4 --}}
        <a href="{{ route('salas.show', 'despacho-neutro') }}" class="tarjeta-sala">
            <div class="emoji-sala">🖥️</div>
            <h3>Despacho Neutro</h3>
            <p>Cero distracciones, foco total.</p>
        </a>

        {{-- Sala 5--}}
        <a href="{{ route('salas.show', 'botica') }}" class="tarjeta-sala">
            <div class="emoji-sala">🧹</div>
            <h3>Botica</h3>
            <p>Con tu caldero</p>
        </a>
    </div>

    <div style="margin-top: 30px; text-align: center;">
        <a href="/" class="enlace-volver">⬅ Volver al menú</a>
    </div>
</div>
@endsection