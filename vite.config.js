import { defineConfig } from 'vite'; // <--- ESTA ES LA LÍNEA MÁGICA
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/componentes/libros.css',
                'resources/css/componentes/estanteria.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});