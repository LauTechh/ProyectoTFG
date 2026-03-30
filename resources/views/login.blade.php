<form action="/login" method="POST">
    @csrf
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    

    <form action="/login" method="POST">
        @csrf
        <button type="submit">Entrar</button>
    </form>

    <hr>
    <p>¿Aún no tienes cuenta? <a href="/registro">Regístrate aquí</a></p>


</form>