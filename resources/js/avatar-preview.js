// resources/js/avatar-preview.js

document.addEventListener('DOMContentLoaded', () => {
    const radios = document.querySelectorAll('input[type="radio"]');
    const textPreview = document.getElementById('preview-text');

    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (textPreview) textPreview.style.display = 'none';

            const category = this.name; 
            const imageSrc = this.nextElementSibling.src;

            if (category === 'avatar_base') {
                updateLayer('preview-base', imageSrc);
            } else if (category === 'avatar_linea') {
                updateLayer('preview-linea', imageSrc);
            } else if (category === 'avatar_ojos') {
                updateLayer('preview-ojos', imageSrc);
            }
        });
    });

    function updateLayer(id, src) {
        const el = document.getElementById(id);
        if (el) {
            el.src = src;
            el.style.display = 'block';
        }
    }
});