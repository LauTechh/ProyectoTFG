// resources/js/cronometro.js

document.addEventListener('DOMContentLoaded', function () {
    let segundosTotales = 0;
    const display = document.getElementById('timer');

    // Solo se activa si en la página existe un elemento con id="timer"
    if (display) {
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
});