import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            ssr: 'resources/js/ssr.js',
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
        VitePWA({
            registerType: 'autoUpdate',
            injectRegister: 'script',
            outDir: 'public',
            includeAssets: ['icons/icon-192.png', 'icons/icon-512.png', 'icons/apple-touch-icon.png'],
            manifest: {
                name: 'MultiVoix',
                short_name: 'MultiVoix',
                description: 'Méditations, formations et services MultiVoix',
                theme_color: '#030712',
                background_color: '#030712',
                display: 'standalone',
                orientation: 'portrait',
                start_url: '/',
                scope: '/',
                lang: 'fr',
                categories: ['lifestyle', 'education', 'music'],
                icons: [
                    {
                        src: '/icons/icon-192.png',
                        sizes: '192x192',
                        type: 'image/png',
                    },
                    {
                        src: '/icons/icon-512.png',
                        sizes: '512x512',
                        type: 'image/png',
                    },
                    {
                        src: '/icons/icon-512.png',
                        sizes: '512x512',
                        type: 'image/png',
                        purpose: 'maskable',
                    },
                ],
                shortcuts: [
                    {
                        name: 'Méditations',
                        short_name: 'Méditations',
                        url: '/meditations',
                        icons: [{ src: '/icons/icon-192.png', sizes: '192x192' }],
                    },
                    {
                        name: 'Formations',
                        short_name: 'Formations',
                        url: '/formations',
                        icons: [{ src: '/icons/icon-192.png', sizes: '192x192' }],
                    },
                ],
            },
            workbox: {
                // Cache les assets statiques indéfiniment
                globPatterns: ['**/*.{js,css,html,ico,png,svg,woff,woff2}'],
                runtimeCaching: [
                    // Pages méditations — Stale While Revalidate
                    {
                        urlPattern: /^https:\/\/guidesenegal\.com\/meditations/,
                        handler: 'StaleWhileRevalidate',
                        options: {
                            cacheName: 'meditations-cache',
                            expiration: { maxEntries: 50, maxAgeSeconds: 7 * 24 * 60 * 60 },
                            cacheableResponse: { statuses: [0, 200] },
                        },
                    },
                    // Pages formations — Stale While Revalidate
                    {
                        urlPattern: /^https:\/\/guidesenegal\.com\/formations/,
                        handler: 'StaleWhileRevalidate',
                        options: {
                            cacheName: 'formations-cache',
                            expiration: { maxEntries: 30, maxAgeSeconds: 7 * 24 * 60 * 60 },
                            cacheableResponse: { statuses: [0, 200] },
                        },
                    },
                    // Fichiers audio — Cache First
                    {
                        urlPattern: /\/storage\/meditations\/audio\/.+\.(mp3|ogg|wav|m4a)$/,
                        handler: 'CacheFirst',
                        options: {
                            cacheName: 'audio-cache',
                            expiration: { maxEntries: 20, maxAgeSeconds: 30 * 24 * 60 * 60 },
                            cacheableResponse: { statuses: [0, 200] },
                            rangeRequests: true,
                        },
                    },
                    // API / pages Inertia — Network First
                    {
                        urlPattern: /^https:\/\/guidesenegal\.com\//,
                        handler: 'NetworkFirst',
                        options: {
                            cacheName: 'pages-cache',
                            expiration: { maxEntries: 60, maxAgeSeconds: 24 * 60 * 60 },
                            cacheableResponse: { statuses: [0, 200] },
                            networkTimeoutSeconds: 5,
                        },
                    },
                ],
                // Page offline de fallback
                navigateFallback: null,
                cleanupOutdatedCaches: true,
            },
        }),
    ],
});
