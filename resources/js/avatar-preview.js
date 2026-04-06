// resources/js/avatar-preview.js

document.addEventListener('DOMContentLoaded', function () {

    // --- 1. LÓGICA DEL AVATAR (PATATA) ---
    const radios = document.querySelectorAll('input[type="radio"]');
    const textPreview = document.getElementById('preview-text');

    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (textPreview) textPreview.style.display = 'none';

            const category = this.name.replace('avatar_', 'preview-');
            const targetImg = document.getElementById(category);

            if (targetImg) {
                const miniImg = this.nextElementSibling;
                if (miniImg && miniImg.tagName === 'IMG') {
                    targetImg.src = miniImg.src;
                    targetImg.style.display = 'block';
                }
            }
        });
    });

    // --- 2. LÓGICA DE INVITADOS (BIBLIOTECA) ---
    const botonesInvitado = document.querySelectorAll('.js-invitado');

    botonesInvitado.forEach(boton => {
        boton.addEventListener('click', function () {
            alert("¡Hola! 🥔 Para añadir este libro a tu biblioteca, necesitas iniciar sesión o crear una cuenta.");
        });
    });
});