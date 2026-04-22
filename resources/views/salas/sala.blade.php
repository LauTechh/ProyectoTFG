@extends('plantilla.app')

@section('clase-body', 'esta-logueado sala-' . $tipo)

@section('content')

@php
$fondos = [
'botica' => 'fondo-botica2.png',
'despacho-rosa' => 'fondo-despacho-rosa.png',
'jardin' => 'fondo-jardin.png',
'dormitorio' => 'fondo-dormitorio.png',
'biblioteca' => 'fondo-biblioteca.png',
];

$fondoActual = $fondos[$tipo] ?? 'fondo-botica.png';
@endphp

<div class="pantalla-estudio">

    {{-- 🖼️ CAPA MAPA --}}
    <div class="capa-mapa" style="position: relative;">

        {{-- FONDO DINÁMICO --}}
        <img src="{{ asset('img/fondo/' . $fondoActual) }}" usemap="#image-map" id="fondo-img">

        {{-- 🔥 CRONÓMETRO MAGÍCO (Sobre el caldero) --}}
        @if($tipo === 'botica')
        <div class="cronometro-caldero">
            <span class="tiempo-display" id="timer">00:00:00</span>
        </div>
        @endif

        {{-- 🔥 NUEVO OVERLAY DEL CAJÓN BOTICA--}}
        @if($tipo === 'botica')
        <img src="{{ asset('img/items/botica/cajon-vacio.png') }}"
            id="cajon-overlay"
            style="position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover; display:none; pointer-events:none; z-index:2;">
        @endif


        {{-- 🔥 BOTES INTERACTIVOS --}}
        @if($tipo === 'botica')
        {{-- Bote 1 - Más a la izquierda --}}
        <img src="{{ asset('img/items/botica/bote/bote1.png') }}"
            class="bote-interactivo" id="bote1"
            style="top: 80%; left: 25%;">

        {{-- Bote 2 - Cerca del caldero --}}
        <img src="{{ asset('img/items/botica/bote/bote2.png') }}"
            class="bote-interactivo" id="bote2"
            style="top: 78%; left: 35%;">

        {{-- Bote 5 - Hacia la derecha --}}
        <img src="{{ asset('img/items/botica/bote/bote5.png') }}"
            class="bote-interactivo" id="bote3"
            style="top: 76%; left: 55%;">
        @endif











        @if($tipo === 'botica')
        <map name="image-map">
            {{-- Tu área del cajón --}}
            <area alt="cajon-vacio" title="cajon-vacio"
                coords="943,513,942,608,1019,629,1029,533,1021,527"
                shape="poly"
                href="javascript:void(0);"
                onclick="toggleCajon()">

            {{-- Área del caldero (la que me has pasado) --}}
            <area coords="374,543,354,580,353,606,371,647,408,682,462,694,519,695,568,677,594,647,615,599,609,561,593,533,541,555,435,558" shape="poly" href="javascript:void(0);">
        </map>
        @endif
    </div>

    {{-- 🎯 UI MINIMALISTA (Para no estorbar) --}}
    <div class="contenido-sala-minimal">
        <div class="cabecera-discreta">
            <h1>{{ $sala['titulo'] }}</h1>
        </div>

        {{-- Si no es botica, mostramos el cronómetro normal aquí --}}
        @if($tipo !== 'botica')
        <div class="cronometro-circular" style="border-color: {{ $sala['color_borde'] }}">
            <span class="tiempo-display" id="timer">00:00:00</span>
        </div>
        @endif

        <div class="botones-inferiores">
            <a href="{{ route('perfil') }}" class="btn-guardar-sesion">TERMINAR</a>
            <a href="{{ route('salas.index') }}" class="btn-volver-atras">SALIR</a>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/image-map-resizer/1.0.10/js/imageMapResizer.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const img = document.getElementById('fondo-img');

        if (img.complete) {
            imageMapResize();
        } else {
            img.onload = () => imageMapResize();
        }
    });

    function toggleCajon() {
        const cajon = document.getElementById('cajon-overlay');
        if (!cajon) return;
        cajon.style.display = cajon.style.display === "block" ? "none" : "block";
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/image-map-resizer/1.0.10/js/imageMapResizer.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const botes = document.querySelectorAll('.bote-interactivo');

        botes.forEach(bote => {
            // Forzamos que se vean al cargar
            console.log("Bote cargado:", bote.id);

            let isDragging = false;
            let offsetX, offsetY;

            bote.addEventListener('mousedown', (e) => {
                isDragging = true;
                const rect = bote.getBoundingClientRect();
                offsetX = e.clientX - rect.left;
                offsetY = e.clientY - rect.top;
                bote.style.zIndex = 1000;
            });

            document.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                e.preventDefault();

                const contenedor = document.querySelector('.capa-mapa');
                const rectContenedor = contenedor.getBoundingClientRect();

                let x = e.clientX - rectContenedor.left - offsetX;
                let y = e.clientY - rectContenedor.top - offsetY;

                bote.style.left = x + 'px';
                bote.style.top = y + 'px';
            });

            document.addEventListener('mouseup', () => {
                isDragging = false;
            });
        });
    });
</script>


@endsection