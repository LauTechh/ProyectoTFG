<h1>📚 ¡Bienvenido a tu Red Social de Libros!</h1>
<p>Hola, {{ Auth::user()->name }}</p>

<div style="border: 2px solid #000; padding: 20px; width: 200px;">
    <h3>Tu Avatar-Patata:</h3>
    <p>Cuerpo: {{ Auth::user()->avatar_base }}</p>
    <p>Línea: {{ Auth::user()->avatar_linea }}</p>
    <p>Ojos: {{ Auth::user()->avatar_ojos }}</p>
</div>

<br>
<form action="/logout" method="POST">
    @csrf
    <button type="submit">Cerrar sesión</button>
</form>