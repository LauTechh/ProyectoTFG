import './bootstrap';
import Swal from 'sweetalert2';
import './avatar-preview'; // <-- Conecta tu código de la patata y avisos
// resources/js/app.js
import './biblioteca';


// Hace que 'Swal' sea accesible globalmente
window.Swal = Swal;

document.addEventListener('DOMContentLoaded', () => {
    // Buscamos si existe nuestro "aviso" de error en el HTML
    const alertData = document.getElementById('validation-alert');

    if (alertData) {
        const message = alertData.getAttribute('data-message');
        Swal.fire({
            icon: 'error',
            title: '¡Ups! Algo va mal',
            text: message,
            confirmButtonColor: '#7c2d12', // Tu color cobrizo
            confirmButtonText: 'Entendido'
        });
    }
});

// --- FUNCIONALIDADES DEL PERFIL ---
// Usamos window. para que el HTML encuentre la función fácilmente
window.toggleFormNombre = function () {
    const container = document.getElementById('form-nombre-container');

    if (!container) return;

    if (container.style.display === 'none' || container.style.display === '') {
        container.style.display = 'block';
        // Foco automático al input para que empieces a escribir directo
        const input = container.querySelector('input');
        if (input) input.focus();
    } else {
        container.style.display = 'none';
    }
};