{{-- resources/views/salas/sala.blade.php --}}
@extends('plantilla.app')

{{-- IMPORTANTE: Sin @endsection aquí porque es de una sola línea --}}
@section('clase-body', 'esta-logueado sala-' . $tipo)

@section('content')
<div class="pantalla-estudio sala-{{ $tipo }}">
    <div class="capa-oscura"></div>

    <div class="contenido-sala">
        <div class="caja-bienvenida">
            <h1 class="titulo-patata">{{ $sala['titulo'] }}</h1>
            <p>{{ $sala['subtitulo'] }}</p>
        </div>

        <div class="cronometro-circular" style="border-color: {{ $sala['color_borde'] }};">
            <div class="info-tiempo">
                <span class="tiempo-display" id="timer">00:00:00</span>
            </div>
        </div>

        <div class="controles-estudio">
            {{-- Este input es para que cronometro.js sepa dónde enviar los datos --}}
            <input type="hidden" id="sala-actual" value="{{ $tipo }}">
            
            <a href="{{ route('perfil') }}" class="btn-guardar-sesion">✨ Terminar Sesión</a>
            <a href="{{ route('salas.index') }}" class="btn-volver-atras">❌ Salir</a>
        </div>
    </div>
</div>

{{-- Asegúrate de que NO haya ningún @vite(['resources/js/biblioteca.js']) aquí abajo --}}
@endsection