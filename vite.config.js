import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/componentes/libros.css', // <--- Revisa que no falte la 's' final
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});