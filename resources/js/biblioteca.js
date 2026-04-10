// resources/js/biblioteca.js

console.log("✅ El archivo biblioteca.js ha sido cargado por el navegador.");

// --- 1. FUNCIÓN PARA AÑADIR LIBROS (AJAX) ---
window.añadirLibroSinRecargar = function (btn) {
    const metaToken = document.querySelector('meta[name="csrf-token"]');
    const metaRoute = document.querySelector('meta[name="route-guardar-libro"]');

    if (!metaToken || !metaRoute) {
        console.warn("⚠️ Falta configuración de metadatos en el layout.");
        return;
    }

    const token = metaToken.getAttribute('content');
    const urlGuardar = metaRoute.getAttribute('content');

    btn.disabled = true;
    const textoOriginal = btn.innerText;
    btn.innerText = "Guardando...";

    const datos = {
        titulo: btn.getAttribute('data-title'),
        autor: btn.getAttribute('data-author'),
        genero: btn.getAttribute('data-genre'),
        portada: btn.getAttribute('data-cover'),
        _token: token
    };

    fetch(urlGuardar, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': token
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

                if (alertaMensaje) alertaMensaje.innerText = "✨ " + data.message;
                if (alertaDiv) alertaDiv.style.display = 'block';

                btn.innerText = "✅ ¡Añadido!";
                btn.style.backgroundColor = "#4CAF50";
                btn.style.color = "white";

                setTimeout(() => {
                    btn.disabled = false;
                    btn.innerText = "+ Añadir";
                    btn.style.backgroundColor = "";
                    btn.style.color = "";
                }, 2000);

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
};

// --- 2. LÓGICA PARA FILTRAR POR GÉNERO (NUEVO) ---
document.addEventListener('click', function (e) {
    // Verificamos si lo que se ha pulsado es un botón de filtro
    if (e.target && e.target.classList.contains('btn-filtro')) {
        const boton = e.target;
        const genero = boton.getAttribute('data-genero');
        const contenedor = document.getElementById('contenedor-libros-ajax');

        // 1. Efecto visual: botón activo
        document.querySelectorAll('.btn-filtro').forEach(b => b.classList.remove('active'));
        boton.classList.add('active');

        // 2. Animación de carga (opcional pero queda profesional)
        if (contenedor) contenedor.style.opacity = '0.5';

        // 3. Petición al servidor (usa encodeURIComponent por si el género tiene espacios)
        fetch(`/estanteria/filtrar?genero=${encodeURIComponent(genero)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => {
                if (!response.ok) throw new Error('Error al filtrar');
                return response.json();
            })
            .then(data => {
                if (contenedor) {
                    contenedor.innerHTML = data.html;
                    contenedor.style.opacity = '1';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (contenedor) contenedor.style.opacity = '1';
            });
    }
});