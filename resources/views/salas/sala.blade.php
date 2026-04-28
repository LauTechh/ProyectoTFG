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

        @if($tipo === 'botica')
        {{-- 🔥 CRONÓMETRO MAGÍCO --}}
        <div class="cronometro-caldero">
            <span class="tiempo-display" id="timer">00:00:00</span>
        </div>

        {{-- 🔥 OVERLAYS --}}
        <img src="{{ asset('img/items/botica/cajon-vacio.png') }}" id="cajon-overlay" class="overlay-item" style="z-index:2;">
        <img src="{{ asset('img/items/botica/caldero-fuego.png') }}" id="caldero-overlay" class="overlay-item" style="z-index:3;">

        {{-- 🔥 BOTES INTERACTIVOS (Ajustados a x:944, y:295 de la estantería) --}}
        {{-- Botes ajustados para entrar en la estantería pequeña --}}
        {{-- Botes MANDADOS a la estantería vacía de la derecha --}}
        <img src="{{ asset('img/items/botica/bote/bote1.png') }}"
            class="bote-interactivo" id="bote1"
            style="top: 44%; left: 74%;"> {{-- Más o menos a la altura del segundo estante --}}

        <img src="{{ asset('img/items/botica/bote/bote2.png') }}"
            class="bote-interactivo" id="bote2"
            style="top: 40%; left: 70%;"> {{-- Un poco más a la derecha --}}


        {{-- Botes en la estantería vacía 2 (Estante de abajo) --}}
        <img src="{{ asset('img/items/botica/bote/bote8.png') }}"
            class="bote-interactivo" id="bote21"
            style="top: 55%; left: 69%;">



        <img src="{{ asset('img/items/botica/bote/bote3.png') }}"
            class="bote-interactivo" id="bote3"
            style="top: 61%; left: 71%;">











        {{-- MAPA DE COORDENADAS (Sincronizado con tus últimos cambios) --}}
        <map name="image-map">
            {{-- Cajón --}}
            <area alt="cajon-vacio" coords="943,513,942,608,1019,629,1029,533,1021,527" shape="poly" href="javascript:void(0);" onclick="toggleCajon()">

            {{-- Caldero (Actualizado a tus coordenadas: 518,477...) --}}
            <area id="area-caldero" coords="518,477,564,466,637,463,657,474,652,489,666,511,664,540,652,557,630,574,600,585,564,582,532,574,510,540,519,506,530,496" shape="poly" href="javascript:void(0);">

            {{-- Estanterías (Invisibles pero mapeadas) --}}
            <area alt="estanteria1" coords="944,295,943,383,1073,388,1079,293" shape="poly" href="javascript:void(0);">
            <area alt="estanteria2" coords="944,398,942,494,1075,505,1079,404" shape="poly" href="javascript:void(0);">
        </map>
        @endif
    </div>

    {{-- 🎯 UI MINIMALISTA --}}
    <div class="contenido-sala-minimal">
        <div class="cabecera-discreta">
            <h1>{{ $sala['titulo'] }}</h1>
        </div>

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

{{-- Scripts unificados --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/image-map-resizer/1.0.10/js/imageMapResizer.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const img = document.getElementById('fondo-img');
        const resizeMap = () => imageMapResize();
        if (img.complete) resizeMap();
        else img.onload = resizeMap;

        // Si la ventana cambia de tamaño, recalculamos el mapa
        window.addEventListener('resize', resizeMap);

        const botes = document.querySelectorAll('.bote-interactivo');
        const calderoOverlay = document.getElementById('caldero-overlay');

        // 1. Hitbox del caldero en PORCENTAJES (de 0 a 100)
        // Calculado de tus coordenadas: (518/1920)*100 ≈ 27, etc.
        const calderoArea = {
            xMin: 26.5, // Izquierda
            xMax: 35.0, // Derecha
            yMin: 43.5, // Arriba
            yMax: 56.5 // Abajo
        };

        botes.forEach(bote => {
            let isDragging = false;
            let offsetX, offsetY;

            // Función unificada para inicio de arrastre (Mouse y Touch)
            const startDrag = (e) => {
                isDragging = true;
                const clientX = e.clientX || e.touches[0].clientX;
                const clientY = e.clientY || e.touches[0].clientY;

                const rect = bote.getBoundingClientRect();
                offsetX = clientX - rect.left;
                offsetY = clientY - rect.top;

                bote.style.zIndex = 1000;
                bote.style.transition = "none";
            };

            // Función unificada para movimiento
            const doDrag = (e) => {
                if (!isDragging) return;
                const clientX = e.clientX || e.touches[0].clientX;
                const clientY = e.clientY || e.touches[0].clientY;

                const contenedor = document.querySelector('.capa-mapa');
                const rectC = contenedor.getBoundingClientRect();

                // Al mover, siempre calcular el % respecto al contenedor actual
                bote.style.left = ((clientX - rectC.left - offsetX) / rectC.width * 100) + '%';
                bote.style.top = ((clientY - rectC.top - offsetY) / rectC.height * 100) + '%';
            };

            // Función unificada para soltar
            const endDrag = (e) => {
                if (!isDragging) return;
                isDragging = false;

                // Usamos el último punto conocido del evento
                const clientX = e.clientX || (e.changedTouches ? e.changedTouches[0].clientX : 0);
                const clientY = e.clientY || (e.changedTouches ? e.changedTouches[0].clientY : 0);

                const rectImg = img.getBoundingClientRect();

                // Calculamos la posición del soltado en % respecto a la imagen actual
                const posXPercent = ((clientX - rectImg.left) / rectImg.width) * 100;
                const posYPercent = ((clientY - rectImg.top) / rectImg.height) * 100;

                // DETECCIÓN RESPONSIVE
                if (posXPercent >= calderoArea.xMin && posXPercent <= calderoArea.xMax &&
                    posYPercent >= calderoArea.yMin && posYPercent <= calderoArea.yMax) {

                    bote.style.display = 'none';
                    if (calderoOverlay) calderoOverlay.style.display = 'block';
                }
            };

            // Eventos de Ratón
            bote.addEventListener('mousedown', startDrag);
            document.addEventListener('mousemove', doDrag);
            document.addEventListener('mouseup', endDrag);

            // Eventos Táctiles (Móviles/Tablets)
            bote.addEventListener('touchstart', startDrag, {
                passive: false
            });
            document.addEventListener('touchmove', doDrag, {
                passive: false
            });
            document.addEventListener('touchend', endDrag);
        });
    });

    function toggleCajon() {
        const cajon = document.getElementById('cajon-overlay');
        if (cajon) {
            cajon.style.display = (cajon.style.display === "block") ? "none" : "block";
        }
    }
</script>

@endsection