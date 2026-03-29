<h2>Paso 2: ¡Personaliza tu Patata! 🥔</h2>

<form action="/registro/finalizar" method="POST">
    @csrf
    
    <div>
        <p>1. Elige el color de tu patata:</p>
        <input type="radio" name="avatar_base" value="azulRelleno.png" required> Azul
        <input type="radio" name="avatar_base" value="rojoRelleno.png"> Rojo
    </div>

    <div>
        <p>2. Elige el borde:</p>
        <input type="radio" name="avatar_linea" value="azulLinea.png" required> Línea Azul
        <input type="radio" name="avatar_linea" value="negroLinea.png"> Línea Negra
    </div>

    <div>
        <p>3. Elige los ojos:</p>
        <input type="radio" name="avatar_ojos" value="ojos1.png" required> Estilo 1
    </div>

    <br>
    <button type="submit">¡Completar Registro!</button>
</form>