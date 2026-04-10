<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- 1. Metadatos de seguridad y rutas --}}
    @yield('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Esta es la línea que le da permiso a biblioteca.js para guardar --}}
    <meta name="route-guardar-libro" content="{{ route('libros.guardar') }}">


    <title>Patata Social Network</title>

    {{-- Icono de la web --}}
    <link rel="icon" type="image/png" href="{{ asset('img/logo/logo_patata.png') }}">

    {{-- 2. Activos con Vite --}}
    @vite([
    'resources/css/app.css',
    'resources/css/componentes/libros.css',
    'resources/css/componentes/estanteria.css',
    'resources/css/componentes/salas.css',
    'resources/js/app.js'
    // ❌ QUITA de aquí la línea de 'resources/js/biblioteca.js'
    ])

    {{-- CSS de emergencia (si existe) --}}
    @if(file_exists(public_path('css/fix-list.css')))
    <link rel="stylesheet" href="{{ asset('css/fix-list.css') }}">
    @endif
</head>

<body class="antialiased {{ Auth::check() ? 'esta-logueado' : 'es-invitado' }}"
    data-sala="@yield('clase-body', 'otra')"
    style="background-image: url('{{ Auth::check() ? asset('img/fondo/fondo2.png') : asset('img/fondo/fondo1.png') }}') !important; 
             background-size: cover !important; 
             background-attachment: fixed !important; 
             background-repeat: no-repeat !important; 
             background-color: transparent !important;">
    {{-- Nav principal --}}
    @include('componentes.nav')


    <div id="alerta-ajax" style="display: none; position: fixed; top: 110px; right: 20px; z-index: 2000;">
        <div id="alerta-mensaje" style="background: #4CAF50; color: white; padding: 15px 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); font-weight: bold;">
            {{-- Aquí el JS escribirá el mensaje --}}
        </div>
    </div>

    {{-- Contenido principal --}}
    <main class="diseño-contenido-principal">
        @yield('content')
    </main>

    {{-- Script del Cronómetro Automático --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const salaActual = document.body.dataset.sala;

            // Solo funciona si hay una sala detectada y no es 'otra'
            if (salaActual && salaActual !== 'otra') {
                console.log("⏱️ Cronómetro iniciado en: " + salaActual);

                setInterval(() => {
                    fetch("{{ route('salas.pulso') }}", { // Asegúrate de que la ruta se llame así en web.php
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                sala: salaActual
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            console.log("✅ 30 segundos registrados en " + salaActual);
                        })
                        .catch(err => {
                            console.error("❌ Error en el pulso:", err);
                        });
                }, 30000);
            }
        });
    </script>

</body>

</html>