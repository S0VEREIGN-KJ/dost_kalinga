import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
               'resources/css/app.css',
                'resources/css/add_proj_overlay.css',
                'resources/css/home.css',           
                'resources/js/app.js',
                'resources/js/home.js',
                'resources/css/admin.css',          
                'resources/js/app.js',
                'resources/js/admin.js',
            ],
            refresh: true,
        }),
    ],
});
