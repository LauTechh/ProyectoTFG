<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personaliza tu Patata - TFG</title>

    <style>
        /* --- ESTILOS CSS PARA LA PATATA-AVATAR --- */
        body {
            font-family: sans-serif;
            text-align: center;
            background-color: #f4f4f9;
            padding: 20px;
        }

        /* Contenedor principal del formulario */
        .avatar-selector {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Escondemos el circulito de radio feo */
        .avatar-selector input[type="radio"] {
            display: none;
        }

        /* Estilo de la etiqueta que envuelve la imagen */
        .avatar-selector label {
            display: inline-block;
            margin: 10px;
            cursor: pointer;
        }

        /* Estilo de la imagen normal (reducida a 1/3 aprox) */
        .avatar-selector img {
            transition: all 0.2s ease-in-out;
            border: 4px solid transparent;
            border-radius: 15px;
            width: 100px;
            /* Tamaño fijo pequeño para practicidad */
            height: 100px;
            /* Mantenemos proporción cuadrada */
            object-fit: contain;
            /* Asegura que se vea todo el PNG */
            background-color: #f9f9f9;
            /* Fondo muy suave para ver el PNG */
            padding: 5px;
        }

        /* Estilo al pasar el ratón */
        .avatar-selector label:hover img {
            background-color: #e0e0e0;
            transform: scale(1.1);
        }

        /* Estilo CUANDO ESTÁ SELECCIONADA */
        .avatar-selector input[type="radio"]:checked+img {
            border-color: #4CAF50;
            /* Borde verde brillante */
            background-color: #e8f5e9;
            /* Fondo verde suave */
            box-shadow: 0 4px 10px rgba(76, 175, 80, 0.3);
        }

        /* Títulos de sección */
        h3 {
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            margin-top: 30px;
            color: #333;
        }

        /* Botón final */
        .btn-finalizar {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            border-radius: 25px;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 40px;
        }

        .btn-finalizar:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <h2>Paso 2: ¡Crea tu Patata-Avatar! 🥔</h2>
    <p>Haz clic en una opción de cada fila para montar tu personaje.</p>

    <form action="/registro/finalizar" method="POST" class="avatar-selector">
        @csrf

        <div>
            <h3>1. Elige el color de tu patata:</h3>

            <label>
                <input type="radio" name="avatar_base" value="base/azulRelleno.png" required>
                <img src="{{ asset('img/avatar/base/azulRelleno.png') }}" alt="Azul">
            </label>

            <label>
                <input type="radio" name="avatar_base" value="base/marronRelleno.png">
                <img src="{{ asset('img/avatar/base/marronRelleno.png') }}" alt="Marrón">
            </label>

            <label>
                <input type="radio" name="avatar_base" value="base/pielRelleno.png">
                <img src="{{ asset('img/avatar/base/pielRelleno.png') }}" alt="Piel">
            </label>

            <label>
                <input type="radio" name="avatar_base" value="base/rosaRelleno.png">
                <img src="{{ asset('img/avatar/base/rosaRelleno.png') }}" alt="Rosa">
            </label>

            <label>
                <input type="radio" name="avatar_base" value="base/verdeRelleno.png">
                <img src="{{ asset('img/avatar/base/verdeRelleno.png') }}" alt="Verde">
            </label>
        </div>

        <div>
            <h3>2. Elige el estilo de borde:</h3>

            <label>
                <input type="radio" name="avatar_linea" value="lineas/azulLinea.png" required>
                <img src="{{ asset('img/avatar/lineas/azulLinea.png') }}" alt="Línea Azul">
            </label>

            <label>
                <input type="radio" name="avatar_linea" value="lineas/marrónLinea.png">
                <img src="{{ asset('img/avatar/lineas/marronLinea.png') }}" alt="Línea Marrón">
            </label>

            <label>
                <input type="radio" name="avatar_linea" value="lineas/pielLinea.png">
                <img src="{{ asset('img/avatar/lineas/pielLinea.png') }}" alt="Línea Piel">
            </label>

            <label>
                <input type="radio" name="avatar_linea" value="lineas/rosaLinea.png">
                <img src="{{ asset('img/avatar/lineas/rosaLinea.png') }}" alt="Línea Rosa">
            </label>

            <label>
                <input type="radio" name="avatar_linea" value="lineas/verdeLineapng.png">
                <img src="{{ asset('img/avatar/lineas/verdeLinea.png') }}" alt="Línea Verde">
            </label>
        </div>

        <div>
            <h3>3. Elige los ojos:</h3>

            <label>
                <input type="radio" name="avatar_ojos" value="ojos/ojos1.png" required>
                <img src="{{ asset('img/avatar/ojos/ojos1.png') }}" alt="Ojos 1">
            </label>

            <label>
                <input type="radio" name="avatar_ojos" value="ojos/ojos2.png">
                <img src="{{ asset('img/avatar/ojos/ojos2.png') }}" alt="Ojos 2">
            </label>

            <label>
                <input type="radio" name="avatar_ojos" value="ojos/ojos3.png">
                <img src="{{ asset('img/avatar/ojos/ojos3.png') }}" alt="Ojos 3">
            </label>
        </div>

        <div id="preview-container" style="position: relative; width: 300px; height: 300px; margin: 20px auto; border: 2px solid #ccc; background: white; overflow: hidden;">

            <img id="preview-base" src="" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 10; display: none; object-fit: contain;">

            <img id="preview-linea" src="" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 20; display: none; object-fit: contain; mix-blend-mode: multiply;">

            <img id="preview-ojos" src="" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 30; display: none; object-fit: contain; mix-blend-mode: multiply;">

            <p id="preview-text" style="text-align: center; margin-top: 130px; color: #999;">Tu patata aparecerá aquí</p>

        </div>
        
        <form action="{{ route('registro.finalizar') }}" method="POST">
            @csrf
            <button type="submit">¡Crear mi cuenta con esta patata!</button>
        </form>


        @vite(['resources/js/avatar-preview.js'])

    </form>

</body>

</html>