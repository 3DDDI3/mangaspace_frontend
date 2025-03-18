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
            "~choices.js": resolve(__dirname, "node_modules/choices.js"),
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/admin/sass/mazer.sass',
                'resources/admin/sass/layouts/auth.sass',
                'resources/admin/sass/layouts/scraper.sass',
                'resources/admin/sass/layouts/chapter.sass',
                'resources/admin/sass/layouts/title.sass',
                'resources/admin/js/index.js',
                'resources/admin/datatable.js',
                'resources/admin/js/mazer.js',
                'resources/js/jquery-3.7.1.js',
                'resources/js/app.js',
                'resources/admin/js/layouts/title.js',
            ],
            refresh: true,
        }),
    ],
});