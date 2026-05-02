<script setup>
import { ref, computed } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';

const page = usePage();
const user = computed(() => page.props.auth?.user);
const sidebarCollapsed = ref(false);
const mobileOpen = ref(false);

const navSections = [
    {
        label: 'Tableau de bord',
        items: [
            { name: 'Dashboard', href: '/admin', icon: 'grid', exact: true },
        ],
    },
    {
        label: 'Contenus',
        items: [
            { name: 'Services', href: '/admin/services', icon: 'mic' },
            { name: 'Formations', href: '/admin/formations', icon: 'graduation' },
            { name: 'Méditations', href: '/admin/meditations', icon: 'meditation' },
            { name: 'Articles', href: '/admin/articles', icon: 'edit' },
        ],
    },
    {
        label: 'Communauté',
        items: [
            { name: 'Utilisateurs', href: '/admin/users', icon: 'users' },
            { name: 'Abonnements', href: '/admin/subscriptions', icon: 'star' },
            { name: 'Commandes', href: '/admin/orders', icon: 'shopping' },
        ],
    },
];

function isActive(href, exact = false) {
    const current = page.url;
    return exact ? current === href : current.startsWith(href);
}

function logout() {
    router.post('/logout');
}
</script>

<template>
    <div class="min-h-screen bg-gray-950 flex">

        <!-- Mobile overlay -->
        <div v-if="mobileOpen" @click="mobileOpen = false"
            class="fixed inset-0 bg-black/60 z-20 lg:hidden backdrop-blur-sm">
        </div>

        <!-- Sidebar -->
        <aside :class="[
            'fixed top-0 left-0 h-full z-30 flex flex-col transition-all duration-300 bg-gray-900 border-r border-green-900/20',
            sidebarCollapsed ? 'w-16' : 'w-64',
            mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
        ]">
            <!-- Logo -->
            <div class="flex items-center h-16 px-4 border-b border-green-900/20 flex-shrink-0">
                <Link href="/admin" class="flex items-center gap-3 overflow-hidden">
                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                        </svg>
                    </div>
                    <span v-if="!sidebarCollapsed" class="font-bold text-white text-lg whitespace-nowrap">
                        Multi<span class="text-green-400">Voix</span>
                        <span class="text-xs font-normal text-gray-500 block -mt-1">Administration</span>
                    </span>
                </Link>
            </div>

            <!-- Nav -->
            <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-6">
                <div v-for="section in navSections" :key="section.label">
                    <p v-if="!sidebarCollapsed" class="px-3 mb-2 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        {{ section.label }}
                    </p>
                    <div class="space-y-1">
                        <Link
                            v-for="item in section.items"
                            :key="item.href"
                            :href="item.href"
                            :class="[
                                'flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 group',
                                isActive(item.href, item.exact)
                                    ? 'bg-green-500/15 text-green-400 border border-green-500/20'
                                    : 'text-gray-400 hover:bg-gray-800 hover:text-white'
                            ]"
                            :title="sidebarCollapsed ? item.name : ''"
                        >
                            <!-- Icons -->
                            <span class="flex-shrink-0 w-5 h-5">
                                <!-- Grid/Dashboard -->
                                <svg v-if="item.icon === 'grid'" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                <!-- Mic -->
                                <svg v-if="item.icon === 'mic'" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                                </svg>
                                <!-- Graduation -->
                                <svg v-if="item.icon === 'graduation'" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                </svg>
                                <!-- Meditation -->
                                <svg v-if="item.icon === 'meditation'" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                </svg>
                                <!-- Edit -->
                                <svg v-if="item.icon === 'edit'" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <!-- Users -->
                                <svg v-if="item.icon === 'users'" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <!-- Star -->
                                <svg v-if="item.icon === 'star'" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                                <!-- Shopping -->
                                <svg v-if="item.icon === 'shopping'" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </span>
                            <span v-if="!sidebarCollapsed" class="whitespace-nowrap">{{ item.name }}</span>
                        </Link>
                    </div>
                </div>
            </nav>

            <!-- User + logout -->
            <div class="flex-shrink-0 border-t border-green-900/20 p-3">
                <div :class="['flex items-center gap-3', sidebarCollapsed ? 'justify-center' : '']">
                    <div class="w-8 h-8 bg-green-500/20 border border-green-500/30 rounded-full flex items-center justify-center text-green-400 font-bold text-sm flex-shrink-0">
                        {{ user?.name?.charAt(0)?.toUpperCase() }}
                    </div>
                    <div v-if="!sidebarCollapsed" class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ user?.name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ user?.email }}</p>
                    </div>
                    <button v-if="!sidebarCollapsed" @click="logout" title="Déconnexion"
                        class="text-gray-600 hover:text-red-400 transition-colors flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main -->
        <div :class="['flex-1 flex flex-col min-h-screen transition-all duration-300', sidebarCollapsed ? 'lg:ml-16' : 'lg:ml-64']">
            <!-- Top bar -->
            <header class="h-16 bg-gray-900/80 border-b border-green-900/20 flex items-center px-4 lg:px-6 gap-4 sticky top-0 z-10 backdrop-blur-md flex-shrink-0">
                <!-- Mobile menu button -->
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- Collapse sidebar button (desktop) -->
                <button @click="sidebarCollapsed = !sidebarCollapsed" class="hidden lg:block text-gray-500 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- Page title slot -->
                <div class="flex-1">
                    <slot name="header" />
                </div>

                <!-- Right actions -->
                <div class="flex items-center gap-3">
                    <Link href="/" target="_blank"
                        class="hidden sm:flex items-center gap-2 text-xs text-gray-500 hover:text-green-400 transition-colors border border-gray-700 hover:border-green-900 px-3 py-1.5 rounded-lg">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Voir le site
                    </Link>
                    <div class="w-8 h-8 bg-green-500/20 border border-green-500/30 rounded-full flex items-center justify-center text-green-400 font-bold text-sm">
                        {{ user?.name?.charAt(0)?.toUpperCase() }}
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 p-4 lg:p-8">
                <slot />
            </main>
        </div>
    </div>
</template>
