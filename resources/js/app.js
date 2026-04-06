import './bootstrap';
import Swal from 'sweetalert2';
import './bootstrap';
import './avatar-preview'; // <-- Esta línea conecta tu código de la patata y los avisos

// Esto hace que puedas usar 'Swal' en cualquier parte si lo necesitas
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