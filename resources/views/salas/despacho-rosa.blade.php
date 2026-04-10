@extends('plantilla.app')

{{-- 1. IDENTIFICADOR PARA EL MAQUINADO AUTOMÁTICO --}}
@section('clase-body', 'despacho-rosa')

@section('content')
<div class="pantalla-estudio sala-despacho-rosa" style="background-color: #fff1f2; min-height: 100vh; width: 100%; position: absolute; top: 0; left: 0; z-index: 10;">

    <div class="caja-bienvenida">
        <h1 class="titulo-patata">{{ $nombreSala }}</h1>
        <p>Disfruta de este ambiente tranquilo para concentrarte. 🌸</p>
    </div>

    <div class="cronometro-circular">
        <div class="info-tiempo">
            <span class="tiempo-display" id="timer">00:00:00</span>
            <p class="etiqueta-tiempo">TIEMPO ENFOCADO</p>
        </div>
    </div>

    <div class="controles-estudio">
        {{-- CAMBIO CLAVE: Ya no hay formulario. El botón es un enlace al perfil --}}
        <a href="{{ route('perfil') }}" class="btn-guardar-sesion" style="text-decoration: none; display: inline-block; line-height: 2.5;">
            ✨ Terminar y ver progreso
        </a>

        <a href="{{ route('salas.index') }}" class="btn-volver-atras" style="text-decoration: none;">❌ Salir sin guardar</a>
    </div>

</div>
@endsection