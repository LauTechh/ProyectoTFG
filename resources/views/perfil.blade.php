<h1>Bienvenida a tu perfil, {{ Auth::user()->name }} 🥔✨</h1>
<p>Aquí es donde irán tus libros y tus publicaciones pronto.</p>

<div style="position: relative; width: 200px; height: 200px; border-radius: 50%; background: #f9f9f9; overflow: hidden; border: 5px solid #333;">
    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_base) }}" style="position: absolute; width: 100%; transform: scale(2.0) translateY(2%);">
    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_linea) }}" style="position: absolute; width: 100%; mix-blend-mode: multiply; transform: scale(2.0) translateY(2%);">
    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_ojos) }}" style="position: absolute; width: 100%; transform: scale(2.0) translateY(2%);">
</div>

<br>
<a href="/menu">⬅ Volver al menú</a>