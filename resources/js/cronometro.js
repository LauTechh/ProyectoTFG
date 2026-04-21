document.addEventListener('DOMContentLoaded', function () {
    const display = document.getElementById('timer');
    const salaActual = document.body.dataset.sala;

    // --- PARTE 1: CRONÓMETRO VISUAL (Se ejecuta si existe el ID "timer") ---
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

    // --- PARTE 2: PULSO AL SERVIDOR (Se ejecuta si estamos en una sala válida) ---
    if (salaActual && salaActual !== 'otra') {
        console.log("⏱️ Envío de pulsos activado para: " + salaActual);

        setInterval(() => {
            const token = document.querySelector('meta[name="csrf-token"]')?.content;

            fetch("/salas/pulso", { // Usamos la URL directa ya que el JS no entiende {{ route }}
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ sala: salaActual })
            })
            .then(res => res.json())
            .then(data => console.log("✅ Pulso registrado en " + salaActual))
            .catch(err => console.error("❌ Error en el pulso:", err));
        }, 30000); // Cada 30 segundos
    }
});