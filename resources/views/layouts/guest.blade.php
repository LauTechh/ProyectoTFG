<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar - Patata Social Network</title>
    {{-- Corregimos también lo del .js que vimos antes --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="guest-body antialiased">

    <div class="guest-container">
        <h1 style="margin-bottom: 20px;">🥔 Libros & Patatas</h1>

        @yield('content')

        <div style="margin-top: 20px;">
            <a href="/" class="back-link">← Volver al inicio</a>
        </div>
    </div>

</body>

</html>