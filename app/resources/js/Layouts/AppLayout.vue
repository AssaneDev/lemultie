<script setup>
import { ref, computed, onMounted } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import PwaBottomNav from '@/Components/PwaBottomNav.vue';
import PwaInstallBanner from '@/Components/PwaInstallBanner.vue';

const page = usePage();
const user = computed(() => page.props.auth?.user);
const mobileMenuOpen = ref(false);
const isHome = computed(() => page.url === '/');
const isPwa = ref(false);
onMounted(() => {
    isPwa.value = window.matchMedia('(display-mode: standalone)').matches
        || window.navigator.standalone === true;
});

const navLinks = [
    { name: 'Accueil',     href: '/',            anchor: null },
    { name: 'Services',    href: '/services',    anchor: '#services' },
    { name: 'Formations',  href: '/formations',  anchor: '#formations' },
    { name: 'Méditations', href: '/meditations', anchor: '#meditations' },
    { name: 'Blog',        href: '/blog',        anchor: '#blog' },
    { name: 'Contact',     href: '/#contact',    anchor: '#contact' },
];

function navHref(link) {
    if (isHome.value && link.anchor) return link.anchor;
    return link.href;
}

function scrollToSection(e, link) {
    if (!isHome.value || !link.anchor) return;
    e.preventDefault();
    const el = document.querySelector(link.anchor);
    if (el) el.scrollIntoView({ behavior: 'smooth' });
    mobileMenuOpen.value = false;
}
</script>

<template>
    <div class="min-h-screen bg-black text-white">
        <!-- Navbar -->
        <nav class="fixed top-0 left-0 right-0 z-50 bg-black/80 backdrop-blur-md border-b border-green-900/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <Link href="/" class="flex items-center space-x-3">
                        <div class="w-8 h-8 relative">
                            <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="16" cy="16" r="6" fill="#22c55e"/>
                                <path d="M8 16 Q10 10 16 10 Q22 10 24 16" stroke="#22c55e" stroke-width="1.5" fill="none" opacity="0.6"/>
                                <path d="M5 16 Q8 6 16 6 Q24 6 27 16" stroke="#22c55e" stroke-width="1" fill="none" opacity="0.3"/>
                                <rect x="15" y="22" width="2" height="6" rx="1" fill="#22c55e"/>
                                <rect x="12" y="27" width="8" height="1.5" rx="0.75" fill="#22c55e"/>
                            </svg>
                        </div>
                        <span class="font-bold text-xl tracking-wide text-white">
                            Multi<span class="text-green-400">Voix</span>
                        </span>
                    </Link>

                    <!-- Desktop Nav -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a
                            v-for="link in navLinks"
                            :key="link.href"
                            :href="navHref(link)"
                            @click="scrollToSection($event, link)"
                            class="text-sm text-gray-300 hover:text-green-400 transition-colors duration-200 cursor-pointer"
                        >
                            {{ link.name }}
                        </a>
                    </div>

                    <!-- Auth -->
                    <div class="hidden md:flex items-center space-x-4">
                        <template v-if="user">
                            <Link :href="route('dashboard')" class="text-sm text-gray-300 hover:text-white">
                                Mon espace
                            </Link>
                            <Link
                                v-if="user.role === 'admin'"
                                href="/admin"
                                class="text-sm text-green-400 hover:text-green-300"
                            >
                                Admin
                            </Link>
                        </template>
                        <template v-else>
                            <Link :href="route('login')" class="text-sm text-gray-300 hover:text-white">
                                Connexion
                            </Link>
                            <Link
                                :href="route('register')"
                                class="px-4 py-2 bg-green-500 hover:bg-green-400 text-black text-sm font-semibold rounded-full transition-colors duration-200"
                            >
                                S'inscrire
                            </Link>
                        </template>
                    </div>

                    <!-- Mobile menu button -->
                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden text-gray-300 hover:text-white"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile menu -->
            <div v-if="mobileMenuOpen" class="md:hidden bg-black/95 border-t border-green-900/30 px-4 py-4 space-y-3">
                <a
                    v-for="link in navLinks"
                    :key="link.href"
                    :href="navHref(link)"
                    @click="scrollToSection($event, link)"
                    class="block text-gray-300 hover:text-green-400 py-2 cursor-pointer"
                >
                    {{ link.name }}
                </a>
                <div class="pt-3 border-t border-green-900/30 flex flex-col space-y-2">
                    <template v-if="user">
                        <Link :href="route('dashboard')" class="text-gray-300">Mon espace</Link>
                    </template>
                    <template v-else>
                        <Link :href="route('login')" class="text-gray-300">Connexion</Link>
                        <Link :href="route('register')" class="bg-green-500 text-black font-semibold text-center py-2 rounded-full">S'inscrire</Link>
                    </template>
                </div>
            </div>
        </nav>

        <!-- Main content -->
        <main :class="['pt-16', isPwa ? 'pb-20' : '']">
            <slot />
        </main>

        <!-- PWA Install Banner (navigateur, pas encore installé) -->
        <PwaInstallBanner v-if="!isPwa" />

        <!-- PWA Bottom Nav (standalone uniquement) -->
        <PwaBottomNav v-if="isPwa" />

        <!-- Footer (masqué en PWA) -->
        <footer v-if="!isPwa" class="bg-black border-t border-green-900/20 py-12 mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <span class="font-bold text-xl">Multi<span class="text-green-400">Voix</span></span>
                        <p class="mt-3 text-gray-400 text-sm leading-relaxed">
                            La voix, le rythme et l'émotion au service de votre expression.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-green-400 uppercase tracking-wider mb-4">Services</h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li><Link href="/services" class="hover:text-white transition-colors">Copywriting</Link></li>
                            <li><Link href="/services" class="hover:text-white transition-colors">Voix off</Link></li>
                            <li><Link href="/services" class="hover:text-white transition-colors">Percussions</Link></li>
                            <li><Link href="/meditations" class="hover:text-white transition-colors">Méditations</Link></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-green-400 uppercase tracking-wider mb-4">Contenus</h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li><Link href="/formations" class="hover:text-white transition-colors">Formations</Link></li>
                            <li><Link href="/blog" class="hover:text-white transition-colors">Blog</Link></li>
                            <li><Link href="/conferences" class="hover:text-white transition-colors">Conférences</Link></li>
                        </ul>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-green-900/20 text-center text-gray-600 text-sm">
                    © {{ new Date().getFullYear() }} Multi-Voix. Tous droits réservés.
                </div>
            </div>
        </footer>
    </div>
</template>
