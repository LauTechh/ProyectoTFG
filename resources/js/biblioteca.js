// resources/js/biblioteca.js



window.añadirLibroSinRecargar = function (btn) {
    // 1. Buscamos los metas con seguridad
    const metaToken = document.querySelector('meta[name="csrf-token"]');
    const metaRoute = document.querySelector('meta[name="route-guardar-libro"]');

    // Comprobación de seguridad: Si no existen, avisamos y paramos
    if (!metaToken || !metaRoute) {
        console.warn("⚠️ Falta configuración de metadatos en el layout.");
        return;
    }

    const token = metaToken.getAttribute('content');
    const urlGuardar = metaRoute.getAttribute('content');

    // Desactivamos el botón para evitar doble click
    btn.disabled = true;
    const textoOriginal = btn.innerText;
    btn.innerText = "Guardando...";

    const datos = {
        title: btn.getAttribute('data-title'),
        author: btn.getAttribute('data-author'),
        genre: btn.getAttribute('data-genre'),
        cover_url: btn.getAttribute('data-cover'),
        _token: token
    };

    fetch(urlGuardar, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token // Es buena práctica enviarlo también en la cabecera
        },
        body: JSON.stringify(datos)
    })
        .then(response => {
            if (!response.ok) throw new Error('Error en la respuesta del servidor');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const alertaDiv = document.getElementById('alerta-ajax');
                const alertaMensaje = document.getElementById('alerta-mensaje');

                // 1. Mostramos la alerta superior y se queda ahí o se va sola
                if (alertaMensaje) alertaMensaje.innerText = "✨ " + data.message;
                if (alertaDiv) alertaDiv.style.display = 'block';

                // 2. Feedback visual inmediato en el botón
                btn.innerText = "✅ ¡Añadido!";
                btn.style.backgroundColor = "#4CAF50";
                btn.style.color = "white";

                // 3. REINICIO DEL BOTÓN: Después de 2 segundos, vuelve a ser clicable
                setTimeout(() => {
                    btn.disabled = false;
                    btn.innerText = "+ Añadir";
                    // Limpiamos los estilos en línea para que vuelva a usar los de tu CSS (layout.css)
                    btn.style.backgroundColor = "";
                    btn.style.color = "";
                }, 2000);

                // 4. La alerta de arriba sí la quitamos después de un rato para no estorbar
                setTimeout(() => {
                    if (alertaDiv) alertaDiv.style.display = 'none';
                }, 4000);

            } else {
                alert("Vaya... no hemos podido guardar el libro. 🥔");
                btn.disabled = false;
                btn.innerText = "+ Añadir";
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btn.disabled = false;
            btn.innerText = textoOriginal;
        });
}