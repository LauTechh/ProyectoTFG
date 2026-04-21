document.addEventListener('DOMContentLoaded', function () {
    const display = document.getElementById('timer');
    const salaActual = document.body.dataset.sala;

    // --- 1. LÓGICA VISUAL (Reloj en pantalla) ---
    // Se ejecuta si existe el elemento con ID 'timer'
    if (display) {
        let segundosTotales = 0;
        console.log("⏳ Cronómetro visual iniciado...");

        setInterval(() => {
            segundosTotales++;
            let hrs = Math.floor(segundosTotales / 3600);
            let mins = Math.floor((segundosTotales % 3600) / 60);
            let secs = segundosTotales % 60;

            display.innerText = 
                `${hrs.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }, 1000);
    }

    // --- 2. LÓGICA DE BASE DE DATOS (Sincronización con Laravel) ---
    // Se ejecuta si estamos dentro de una sala válida
    if (salaActual && salaActual !== 'otra') {
        console.log("⏱️ Envío de pulsos activado para la sala: " + salaActual);

        setInterval(() => {
            const token = document.querySelector('meta[name="csrf-token"]')?.content;

            // Usamos la URL que definimos en tus rutas de Laravel
            fetch("/salas/registrar-pulso", { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ sala: salaActual })
            })
            .then(res => res.json())
            .then(data => {
                console.log("✅ Tiempo sincronizado con el servidor para: " + salaActual);
            })
            .catch(err => {
                console.error("❌ Error al registrar el pulso:", err);
            });
        }, 30000); // Se sincroniza cada 30 segundos
    }
});