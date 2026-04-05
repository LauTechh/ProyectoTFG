<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar - Patata Social Network</title>
    
    {{-- Cargamos los activos con Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased es-invitado"
    style="background-image: url('{{ asset('img/fondo/fondo1.png') }}') !important; 
           background-size: cover !important; 
           background-attachment: fixed !important; 
           background-repeat: no-repeat !important;">

    {{-- Usamos las nuevas clases en español de tu app.css --}}
    <div class="cuerpo-invitado">
        <div class="contenedor-invitado">
            
            <h1 style="margin-bottom: 20px; font-size: 2.5rem; color: #5d4037; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
                🥔 Libros & Patatas
            </h1>

            {{-- Aquí se inyectará el formulario de Login o Registro --}}
            @yield('content')

            <div style="margin-top: 20px;">
                <a href="/" style="text-decoration: none; color: #b87333; font-weight: bold; transition: 0.3s;" 
                   onmouseover="this.style.color='#cd7f32'" onmouseout="this.style.color='#b87333'">
                    ← Volver al inicio
                </a>
            </div>
        </div>
    </div>

</body>

</html>