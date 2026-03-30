<h1>📚 ¡Bienvenido a tu Red Social de Libros!</h1>
<p>Hola, {{ Auth::user()->name }}</p>

<div style="position: relative; width: 50px; height: 50px; border-radius: 50%; background: #eee; overflow: hidden; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    
    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_base) }}" 
         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; z-index: 1; transform: scale(2.0) translateY(2%);">
    
    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_linea) }}" 
         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; z-index: 2; mix-blend-mode: multiply; transform: scale(2.0) translateY(2%);">
    
    <img src="{{ asset('img/avatar/' . Auth::user()->avatar_ojos) }}" 
         style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; z-index: 3; transform: scale(2.0) translateY(2%);">

</div>

<span style="margin-left: 10px; font-weight: bold; color: #333;">
    {{ Auth::user()->name }}
</span>

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