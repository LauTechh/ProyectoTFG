// resources/js/sala-interactiva.js

export function initSalaInteractiva(salaId, userPotato) {
    // =====================================================
    // 🕒 TIMER
    // =====================================================

    let segundos = 0;
    let timerInterval = null;

    function iniciarTimer() {
        const el = document.getElementById("timer");

        if (!el) {
            console.warn("⚠️ No se encontró el timer");
            return;
        }

        // Evita múltiples intervals
        if (timerInterval) {
            clearInterval(timerInterval);
        }

        console.log("✅ Timer iniciado");

        timerInterval = setInterval(() => {
            segundos++;

            const hrs = Math.floor(segundos / 3600);
            const mins = Math.floor((segundos % 3600) / 60);
            const secs = segundos % 60;

            const fmt = (n) => String(n).padStart(2, "0");

            el.textContent = `${fmt(hrs)}:${fmt(mins)}:${fmt(secs)}`;

            const barra = document.getElementById("focus-bar");

            if (barra) {
                const objetivo = 3600; // 1 hora

                const progreso = Math.min((segundos / objetivo) * 100, 100);

                barra.style.width = progreso + "%";
            }
        }, 1000);
    }

    iniciarTimer();

    // =====================================================
    // 💓 PULSO AUTOMÁTICO
    // =====================================================

    let pulsoInterval = null;

    if (pulsoInterval) {
        clearInterval(pulsoInterval);
    }

    pulsoInterval = setInterval(() => {
        const root = document.getElementById("sala-interactiva-root");
        const csrf = document.querySelector('meta[name="csrf-token"]');

        if (!root || !csrf) return;

        const tipoSala = root.getAttribute("data-tipo");

        fetch("/salas/registrar-pulso", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrf.getAttribute("content"),
            },
            body: JSON.stringify({
                sala: tipoSala,
            }),
        })
            .then(async (response) => {
                const text = await response.text();

                if (!response.ok) {
                    throw new Error(text);
                }

                return JSON.parse(text);
            })
            .then(() => {
                console.log(`💓 Pulso enviado: ${tipoSala}`);
            })
            .catch((err) => {
                console.error("❌ Error en el pulso:", err);
            });
    }, 60000);

    // =====================================================
    // 🥔 CHAT
    // =====================================================

    window.enviarMensaje = function () {
        const input = document.getElementById("chat-input");
        const box = document.getElementById("chat-box");

        if (!input || !box) return;

        const texto = input.value.trim();

        if (texto === "") return;

        const msjObj = {
            nombre: userPotato,
            texto: texto,
        };

        const div = document.createElement("div");

        div.className = "mensaje";
        div.innerHTML = `<b>${msjObj.nombre}:</b> ${msjObj.texto}`;

        box.appendChild(div);

        const hist = JSON.parse(localStorage.getItem("chat_" + salaId) || "[]");

        hist.push(msjObj);

        localStorage.setItem("chat_" + salaId, JSON.stringify(hist));

        input.value = "";

        box.scrollTop = box.scrollHeight;
    };

    function cargarMensajes() {
        const box = document.getElementById("chat-box");

        if (!box) return;

        const hist = JSON.parse(localStorage.getItem("chat_" + salaId) || "[]");

        box.innerHTML = `
            <div class="mensaje">
                <b>Sistema:</b>
                Hola ${userPotato}, bienvenida a ${salaId}.
            </div>
        `;

        hist.forEach((m) => {
            const div = document.createElement("div");

            div.className = "mensaje";

            div.innerHTML = `
                <b>${m.nombre || "Patata"}:</b>
                ${m.texto}
            `;

            box.appendChild(div);
        });

        box.scrollTop = box.scrollHeight;
    }

    cargarMensajes();

    const chatInput = document.getElementById("chat-input");

    if (chatInput) {
        chatInput.addEventListener("keypress", (e) => {
            if (e.key === "Enter") {
                window.enviarMensaje();
            }
        });
    }

    // =====================================================
    // 🧪 BOTICA
    // =====================================================

    if (salaId === "botica") {
        let boteActivo = null;
        let offX = 0;
        let offY = 0;

        const botes = document.querySelectorAll(".bote-interactivo");

        const calderoArea = {
            xMin: 18,
            xMax: 48,
            yMin: 35,
            yMax: 82,
        };

        botes.forEach((bote) => {
            bote.addEventListener("mousedown", (e) => {
                boteActivo = bote;

                const rect = bote.getBoundingClientRect();

                offX = e.clientX - rect.left;
                offY = e.clientY - rect.top;

                bote.style.zIndex = 1000;
            });
        });

        document.addEventListener("mousemove", (e) => {
            if (!boteActivo) return;

            const contenedor = document
                .querySelector(".capa-mapa")
                .getBoundingClientRect();

            boteActivo.style.left =
                ((e.clientX - contenedor.left - offX) / contenedor.width) *
                    100 +
                "%";

            boteActivo.style.top =
                ((e.clientY - contenedor.top - offY) / contenedor.height) *
                    100 +
                "%";
        });

        document.addEventListener("mouseup", (e) => {
            if (!boteActivo) return;

            const rImg = document
                .getElementById("fondo-img")
                .getBoundingClientRect();

            const px = ((e.clientX - rImg.left) / rImg.width) * 100;

            const py = ((e.clientY - rImg.top) / rImg.height) * 100;

            if (
                px >= calderoArea.xMin &&
                px <= calderoArea.xMax &&
                py >= calderoArea.yMin &&
                py <= calderoArea.yMax
            ) {
                boteActivo.style.display = "none";

                document.querySelectorAll(".reaccion-caldero").forEach((r) => {
                    r.style.display = "none";
                });

                const reaccion = document.getElementById(
                    "reaccion-" + boteActivo.id,
                );

                if (reaccion) {
                    reaccion.style.display = "block";
                }
            }

            boteActivo.style.zIndex = 100;
            boteActivo = null;
        });
    }
}

// =====================================================
// 🌐 FUNCIONES GLOBALES
// =====================================================

window.toggleCajon = function () {
    const c = document.getElementById("cajon-overlay");

    if (!c) return;

    c.style.display = c.style.display === "block" ? "none" : "block";
};

window.finalizarSesion = function (event) {
    event.preventDefault();

    const timer = document.getElementById("timer");

    const root = document.getElementById("sala-interactiva-root");

    const urlDestino = event.currentTarget.href;

    if (!timer || !root) {
        window.location.href = urlDestino;
        return;
    }

    const partes = timer.innerText.split(":").map(Number);

    const segundosTotales = partes[0] * 3600 + partes[1] * 60 + partes[2];

    fetch("/salas/guardar", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({
            sala: root.getAttribute("data-tipo"),
            segundos: segundosTotales,
        }),
    }).finally(() => {
        window.location.href = urlDestino;
    });
};
