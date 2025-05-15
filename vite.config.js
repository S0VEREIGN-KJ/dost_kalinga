import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',           // Your main app.css
                'resources/js/app.js',             // Your main app.js
            ],
            refresh: true,
        }),
    ],
});
