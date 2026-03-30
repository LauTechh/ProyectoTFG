<!DOCTYPE html>
<html>

<head>
    <title>Patata Social Network</title>
    <style>
        nav {
            text-align: right;
            padding: 20px;
            background: #eee;
        }

        .btn {
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
   

    <nav>
        @auth
        <span>Hola, <strong>{{ Auth::user()->name }}</strong> 🥔</span>

        <a href="/menu" class="btn">Mi Perfil</a>

        <form action="/logout" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn" style="background: #ff4444; border:none; cursor:pointer;">Cerrar sesión</button>
        </form>

        <a href="/login" class="btn" style="background: #555;">Usar otra cuenta</a>
        @endauth

        @guest
        <a href="/login" class="btn">Inicia sesión</a>
        <a href="/registro" class="btn" style="background: #333;">Crear cuenta</a>
        @endguest
    </nav>


    <main style="text-align: center; margin-top: 50px;">
        <h1>Bienvenido a la Red Social de Libros 🥔📚</h1>
        <p>Crea tu avatar y comparte tus lecturas favoritas.</p>
    </main>
</body>

</html>