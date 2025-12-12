import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            // Only load JS via Vite; CSS is still handled via the existing Tailwind CDN in the layout
            input: ['resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
});
