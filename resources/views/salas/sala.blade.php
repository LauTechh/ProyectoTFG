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

<style>
    /* 🕒 Estilos Cronómetro */
    .cronometro-caldero {
        position: absolute;
        top: 15%;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 0, 0, 0.6);
        padding: 10px 20px;
        border-radius: 50px;
        border: 2px solid #b89356;
        z-index: 10;
    }

    .tiempo-display {
        color: #fff;
        font-family: 'Courier New', Courier, monospace;
        font-size: 1.5rem;
        font-weight: bold;
        text-shadow: 0 0 10px #ffca28;
    }

    /* 🥔 Estilos Chat */
    .ventana-comentarios {
        position: absolute;
        bottom: 25px;
        left: 25px;
        width: 280px;
        height: 220px;
        background: rgba(30, 20, 15, 0.95);
        border: 2px solid #b89356;
        border-radius: 12px;
        z-index: 3000;
        display: flex;
        flex-direction: column;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
        overflow: hidden;
    }

    .chat-header {
        background: #b89356;
        color: #fff;
        padding: 6px 12px;
        font-family: 'Cinzel', serif;
        font-size: 0.75rem;
        display: flex;
        justify-content: space-between;
    }

    .chat-messages {
        flex: 1;
        padding: 10px;
        overflow-y: auto;
        color: #e0d0b0;
        font-size: 0.85rem;
    }

    .mensaje { margin-bottom: 6px; border-bottom: 1px solid rgba(184, 147, 86, 0.2); padding-bottom: 2px; }
    .mensaje b { color: #ffca28; font-size: 0.7rem; text-transform: uppercase; }

    .chat-input-area {
        display: flex;
        padding: 8px;
        background: rgba(0, 0, 0, 0.3);
        gap: 5px;
    }

    .chat-input-area input {
        flex: 1;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid #b89356;
        border-radius: 5px;
        color: white;
        padding: 4px 8px;
    }

    .chat-input-area button {
        background: #b89356;
        border: none;
        color: white;
        padding: 4px 10px;
        border-radius: 5px;
        cursor: pointer;
    }
</style>

<div class="pantalla-estudio">

    <div class="capa-mapa" style="position: relative; display: inline-block;">
        <img src="{{ asset('img/fondo/' . $fondoActual) }}" usemap="#image-map" id="fondo-img">

        @if($tipo === 'botica')
            <div class="cronometro-caldero">
                <span class="tiempo-display" id="timer">00:00:00</span>
            </div>

            {{-- Elementos de Botica --}}
            <img src="{{ asset('img/items/botica/cajon-vacio.png') }}" id="cajon-overlay" class="overlay-item" style="z-index:2; display:none;">
            <div id="reacciones-contenedor">
                <img src="{{ asset('img/items/botica/caldero/caldero1.png') }}" id="reaccion-bote1" class="reaccion-caldero" style="display:none; z-index:4;">
                <img src="{{ asset('img/items/botica/caldero/caldero2.png') }}" id="reaccion-bote2" class="reaccion-caldero" style="display:none; z-index:4;">
                <img src="{{ asset('img/items/botica/caldero/caldero3.png') }}" id="reaccion-bote3" class="reaccion-caldero" style="display:none; z-index:4;">
                <img src="{{ asset('img/items/botica/caldero/caldero4.png') }}" id="reaccion-bote8" class="reaccion-caldero" style="display:none; z-index:4;">
            </div>

            <img src="{{ asset('img/items/botica/bote/bote1.png') }}" class="bote-interactivo" id="bote1" style="top: 44%; left: 74%;">
            <img src="{{ asset('img/items/botica/bote/bote2.png') }}" class="bote-interactivo" id="bote2" style="top: 40%; left: 70%;">
            <img src="{{ asset('img/items/botica/bote/bote8.png') }}" class="bote-interactivo" id="bote8" style="top: 55%; left: 69%;">
            <img src="{{ asset('img/items/botica/bote/bote3.png') }}" class="bote-interactivo" id="bote3" style="top: 61%; left: 71%;">

            <map name="image-map">
                <area alt="cajon" coords="943,513,942,608,1019,629,1029,533" shape="poly" href="javascript:void(0);" onclick="toggleCajon()">
                <area id="area-caldero" coords="518,477,657,474,630,574,510,540" shape="poly" href="javascript:void(0);">
            </map>
        @endif

        {{-- 🥔 VENTANA CHAT --}}
        <div class="ventana-comentarios">
            <div class="chat-header">
                <span>PATATA-LOG ({{ strtoupper($tipo) }})</span>
                <span style="cursor:pointer" onclick="document.querySelector('.ventana-comentarios').style.opacity='0.3'">_</span>
            </div>
            <div class="chat-messages" id="chat-box"></div>
            <div class="chat-input-area">
                <input type="text" id="chat-input" placeholder="Escribe algo...">
                <button onclick="enviarMensaje()">➤</button>
            </div>
        </div>
    </div>

    <div class="contenido-sala-minimal">
        <div class="cabecera-discreta"><h1>{{ $sala['titulo'] }}</h1></div>

        @if($tipo !== 'botica')
            <div class="cronometro-circular" style="border-color: {{ $sala['color_borde'] }}">
                <span class="tiempo-display" id="timer">00:00:00</span>
            </div>
        @endif

        <div class="botones-inferiores">
            <a href="{{ route('perfil') }}" class="btn-estudio btn-finalizar">TERMINAR</a>
            <a href="{{ route('salas.index') }}" class="btn-estudio btn-cambiar-sala">CAMBIAR SALA</a>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/image-map-resizer/1.0.10/js/imageMapResizer.min.js"></script>

<script>
    // Variables Globales (SOLO UNA VEZ CADA UNA)
    const salaId = "{{ $tipo }}";
    const userPotato = "{{ Auth::user()->name }}";
    let segundos = 0;
    let boteActivo = null;
    let offX, offY;

    // --- 🕒 TIMER ---
    setInterval(() => {
        segundos++;
        let hrs = Math.floor(segundos / 3600);
        let mins = Math.floor((segundos % 3600) / 60);
        let secs = segundos % 60;
        const fmt = (n) => n < 10 ? "0"+n : n;
        const el = document.getElementById("timer");
        if(el) el.innerText = `${fmt(hrs)}:${fmt(mins)}:${fmt(secs)}`;
    }, 1000);

    // --- 🥔 CHAT ---
    function enviarMensaje() {
        const input = document.getElementById('chat-input');
        const box = document.getElementById('chat-box');
        const texto = input.value.trim();

        if (texto !== "") {
            const msjObj = { nombre: userPotato, texto: texto };
            
            // Renderizar
            const div = document.createElement('div');
            div.className = 'mensaje';
            div.innerHTML = `<b>${msjObj.nombre}:</b> ${msjObj.texto}`;
            box.appendChild(div);

            // Guardar
            const hist = JSON.parse(localStorage.getItem('chat_' + salaId) || "[]");
            hist.push(msjObj);
            localStorage.setItem('chat_' + salaId, JSON.stringify(hist));

            input.value = "";
            box.scrollTop = box.scrollHeight;
        }
    }

    function cargarMensajes() {
        const box = document.getElementById('chat-box');
        const hist = JSON.parse(localStorage.getItem('chat_' + salaId) || "[]");
        box.innerHTML = `<div class="mensaje"><b>Sistema:</b> Hola ${userPotato}, bienvenida a ${salaId}.</div>`;
        
        hist.forEach(m => {
            const div = document.createElement('div');
            div.className = 'mensaje';
            div.innerHTML = `<b>${m.nombre || 'Patata'}:</b> ${m.texto}`;
            box.appendChild(div);
        });
        box.scrollTop = box.scrollHeight;
    }

    // --- 🧪 ARRASTRE ---
    document.addEventListener('DOMContentLoaded', () => {
        cargarMensajes();
        imageMapResize();

        // Evento Enter en chat
        document.getElementById('chat-input').addEventListener('keypress', (e) => {
            if(e.key === 'Enter') enviarMensaje();
        });

        if (salaId === 'botica') {
            const botes = document.querySelectorAll('.bote-interactivo');
            const calderoArea = { xMin: 18, xMax: 48, yMin: 35, yMax: 82 };

            botes.forEach(bote => {
                bote.addEventListener('mousedown', (e) => {
                    boteActivo = bote;
                    const rect = bote.getBoundingClientRect();
                    offX = e.clientX - rect.left;
                    offY = e.clientY - rect.top;
                    bote.style.zIndex = 1000;
                });
            });

            document.addEventListener('mousemove', (e) => {
                if (!boteActivo) return;
                const contenedor = document.querySelector('.capa-mapa').getBoundingClientRect();
                boteActivo.style.left = ((e.clientX - contenedor.left - offX) / contenedor.width * 100) + '%';
                boteActivo.style.top = ((e.clientY - contenedor.top - offY) / contenedor.height * 100) + '%';
            });

            document.addEventListener('mouseup', (e) => {
                if (!boteActivo) return;
                const rImg = document.getElementById('fondo-img').getBoundingClientRect();
                const px = ((e.clientX - rImg.left) / rImg.width) * 100;
                const py = ((e.clientY - rImg.top) / rImg.height) * 100;

                if (px >= calderoArea.xMin && px <= calderoArea.xMax && py >= calderoArea.yMin && py <= calderoArea.yMax) {
                    boteActivo.style.display = 'none';
                    document.querySelectorAll('.reaccion-caldero').forEach(r => r.style.display = 'none');
                    const r = document.getElementById('reaccion-' + boteActivo.id);
                    if(r) r.style.display = 'block';
                }
                boteActivo.style.zIndex = 100;
                boteActivo = null;
            });
        }
    });

    function toggleCajon() {
        const c = document.getElementById('cajon-overlay');
        if(c) c.style.display = (c.style.display === "block") ? "none" : "block";
    }
</script>

@endsection