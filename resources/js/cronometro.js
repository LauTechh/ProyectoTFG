document.addEventListener('DOMContentLoaded', function () {
    const salaActual = document.body.dataset.sala;

    // 🔍 CORRECCIÓN: Buscamos por ID 'timer', que es lo que tienes en tu HTML
    const display = document.getElementById('timer');

    if (salaActual && salaActual !== 'otra') {
        console.log("⏱️ Cronómetro iniciado en: " + salaActual);

        // --- 1. LÓGICA VISUAL (Reloj de la pantalla) ---
        let segundosTranscurridos = 0;

        setInterval(() => {
            segundosTranscurridos++;

            let hrs = Math.floor(segundosTranscurridos / 3600);
            let mins = Math.floor((segundosTranscurridos % 3600) / 60);
            let secs = segundosTranscurridos % 60;

            // Actualiza el texto en la pantalla (00:00:00)
            if (display) {
                display.innerText =
                    `${hrs.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            }
        }, 1000); // Se ejecuta cada segundo

        // --- 2. LÓGICA DE BASE DE DATOS (Sincronización con Laravel) ---
        setInterval(() => {
            const token = document.querySelector('meta[name="csrf-token"]')?.content;

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
                    console.log("✅ Tiempo sincronizado con el servidor");
                })
                .catch(err => {
                    console.error("❌ Error al registrar el pulso:", err);
                });
        }, 30000); // Se ejecuta cada 30 segundos
    }
});