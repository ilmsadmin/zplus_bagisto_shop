import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'src/Resources/assets/css/vipos.css',
                'src/Resources/assets/js/vipos.js'
            ],
            refresh: true,
        }),
    ],
});