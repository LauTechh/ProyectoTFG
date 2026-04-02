// resources/js/avatar-preview.js
document.addEventListener('DOMContentLoaded', function() {
    const radios = document.querySelectorAll('input[type="radio"]');
    const textPreview = document.getElementById('preview-text');
    
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
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
});

