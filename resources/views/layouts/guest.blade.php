<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar - Patata Social Network</title>
    @vite(['resources/css/app.css', 'resources/js/app.css'])
</head>
<body style="background-color: #f4f4f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;">

   <div style="background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 90%; max-width: 800px; text-align: center; margin: 20px;">     <h1 style="margin-bottom: 20px;">🥔 Libros & Patatas</h1>
        
        @yield('content')

        <div style="margin-top: 20px;">
            <a href="/" style="color: #888; text-decoration: none; font-size: 0.9em;">← Volver al inicio</a>
        </div>
    </div>

</body>
</html>