import './bootstrap';
import Swal from 'sweetalert2';
import './avatar-preview';
import './biblioteca'; // Importado una sola vez, ¡perfecto!

// Hace que 'Swal' sea accesible globalmente para usarlo en cualquier parte
window.Swal = Swal;

// --- ALERTAS DE VALIDACIÓN (SweetAlert) ---
document.addEventListener('DOMContentLoaded', () => {
    const alertData = document.getElementById('validation-alert');

    if (alertData) {
        const message = alertData.getAttribute('data-message');
        Swal.fire({
            icon: 'error',
            title: '¡Ups! Algo va mal',
            text: message,
            confirmButtonColor: '#7c2d12',
            confirmButtonText: 'Entendido'
        });
    }
});

// --- FUNCIONALIDADES GLOBALES (Accesibles desde el HTML) ---

// 1. Mostrar/Ocultar formulario de cambio de nombre
window.toggleFormNombre = function () {
    const container = document.getElementById('form-nombre-container');
    if (!container) return;

    if (container.style.display === 'none' || container.style.display === '') {
        container.style.display = 'block';
        const input = container.querySelector('input');
        if (input) input.focus();
    } else {
        container.style.display = 'none';
    }
};

// 2. Alerta para usuarios no registrados
window.alertaInvitado = function () {
    Swal.fire({
        title: '¡Hola, patata! 🥔',
        text: 'Para añadir libros a tu biblioteca personal necesitas una cuenta.',
        icon: 'info',
        confirmButtonColor: '#f97316',
        confirmButtonText: '¡Entendido!'
    });
};