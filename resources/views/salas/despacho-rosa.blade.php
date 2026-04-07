@extends('plantilla.app')

@section('content')
<div class="pantalla-estudio sala-despacho-rosa" style="background-color: #fff1f2; min-height: 100vh; width: 100%; position: absolute; top: 0; left: 0; z-index: 10;">

    <div class="pantalla-estudio sala-despacho-rosa">

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
            <form id="form-finalizar" action="{{ route('salas.guardar') }}" method="POST">
                @csrf
                <input type="hidden" name="segundos" id="input-segundos" value="0">
                <input type="hidden" name="sala" value="{{ $tipo }}">
                <button type="submit" class="btn-guardar-sesion">
                    ✨ Finalizar y Guardar
                </button>
            </form>

            <a href="{{ route('salas.index') }}" class="btn-volver-atras">❌ Salir</a>
        </div>

    </div>

    <script>
        let segundosTotales = 0;
        const display = document.getElementById('timer');
        const inputSegundos = document.getElementById('input-segundos');

        setInterval(() => {
            segundosTotales++;
            inputSegundos.value = segundosTotales;

            let hrs = Math.floor(segundosTotales / 3600);
            let mins = Math.floor((segundosTotales % 3600) / 60);
            let secs = segundosTotales % 60;

            display.innerText =
                `${hrs.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }, 1000);
    </script>
</div>
@endsection