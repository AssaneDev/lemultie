<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const url = computed(() => page.url);

const tabs = [
    {
        name: 'Accueil',
        href: '/',
        icon: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>`,
    },
    {
        name: 'Méditations',
        href: '/meditations',
        icon: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>`,
    },
    {
        name: 'Formations',
        href: '/formations',
        icon: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>`,
    },
    {
        name: 'Blog',
        href: '/blog',
        icon: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>`,
    },
    {
        name: 'Compte',
        href: '/dashboard',
        icon: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>`,
    },
];

function isActive(href) {
    if (href === '/') return url.value === '/';
    return url.value.startsWith(href);
}
</script>

<template>
    <nav class="fixed bottom-0 left-0 right-0 z-50 bg-gray-950/95 backdrop-blur-xl border-t border-green-900/20"
        style="padding-bottom: env(safe-area-inset-bottom)">
        <div class="flex items-stretch">
            <Link
                v-for="tab in tabs"
                :key="tab.href"
                :href="tab.href"
                class="flex-1 flex flex-col items-center justify-center gap-0.5 py-3 transition-colors duration-150 relative"
                :class="isActive(tab.href) ? 'text-green-400' : 'text-gray-600 active:text-gray-400'"
            >
                <!-- Active indicator -->
                <span v-if="isActive(tab.href)"
                    class="absolute top-0 left-1/2 -translate-x-1/2 w-8 h-0.5 bg-green-400 rounded-full"></span>

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" v-html="tab.icon"></svg>
                <span class="text-[10px] font-medium tracking-tight">{{ tab.name }}</span>
            </Link>
        </div>
    </nav>
</template>
