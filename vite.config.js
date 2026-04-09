// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/componentes/libros.css', // <-- ¡AÑADE ESTA LÍNEA!
                'resources/css/componentes/estanteria.css',
                'resources/css/componentes/salas.css',
                'resources/js/app.js',
                'resources/css/perfil.css',
            ],
            refresh: true,
        }),
    ],
});