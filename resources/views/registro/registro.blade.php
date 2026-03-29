<h2>Crear cuenta en Red Social de Libros</h2>

<form action="/registro" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Tu nombre completo" required>
    <br><br>
    <input type="email" name="email" placeholder="Tu email" required>
    <br><br>
    <input type="password" name="password" placeholder="Crea una contraseña" required>
    <br><br>
    <button type="submit">Registrarme</button>
</form>

<p>¿Ya tienes cuenta? <a href="/login">Entra aquí</a></p>