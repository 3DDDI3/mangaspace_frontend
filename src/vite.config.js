import { defineConfig } from 'vite';
import { resolve } from 'path';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            host: "mangaspace.ru",
        },
    },
    resolve: {
        alias: {
            "~bootstrap": resolve(__dirname, "node_modules/bootstrap"),
            "~bootstrap-icons": resolve(
                __dirname,
                "node_modules/bootstrap-icons",
            ),
            "~perfect-scrollbar": resolve(
                __dirname,
                "node_modules/perfect-scrollbar",
            ),
            "~@fontsource": resolve(__dirname, "node_modules/@fontsource"),
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/mazer.sass',
                'resources/js/jquery-3.7.1.js',
                'resources/js/app.js',
                'resources/admin/js/main.js',
            ],
            refresh: true,
        }),
    ],
});