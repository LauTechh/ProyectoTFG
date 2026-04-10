@extends('plantilla.app')
@section('clase-body', 'botica') {{-- Clave para el pulso --}}

@section('content')
<div class="pantalla-estudio sala-biblioteca" style="background-color: #f0fdf4; min-height: 100vh;">
    <div class="caja-bienvenida">
        <h1 class="titulo-patata">Botica🧙🏼‍♂️</h1>
        <p>Silencio... las patatas están estudiando.</p>
    </div>

    <div class="cronometro-circular">
        <div class="info-tiempo">
            <span class="tiempo-display" id="timer">00:00:00</span> {{-- Clave para el visual --}}
        </div>
    </div>

    <div class="controles-estudio">
        <a href="{{ route('perfil') }}" class="btn-guardar-sesion">✨ Terminar Sesión</a>
        <a href="{{ route('salas.index') }}" class="btn-volver-atras">❌ Salir</a>
    </div>
</div>
@endsection