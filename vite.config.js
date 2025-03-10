import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        hmr: {
          // Set the ip only if you're using "--host" flag via cli
          // or the server won't work on your local machine,
          // you'll be forced to use --host every time.
          host: process.argv.includes('--host') ? '192.168.1.109' : null
        }
    },
});
