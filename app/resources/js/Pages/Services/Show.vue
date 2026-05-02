<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    service: Object,
});

const categoryLabels = {
    copywriting: 'Copywriting',
    voix_off: 'Voix Off',
    percussion: 'Percussions',
    conte: 'Contes & Storytelling',
    meditation: 'Méditations',
    formation: 'Formations',
    conference: 'Conférences',
};
</script>

<template>
    <AppLayout>
        <div class="py-20 px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-8">
                    <Link href="/services" class="hover:text-green-400 transition-colors">Services</Link>
                    <span>/</span>
                    <span class="text-gray-300">{{ service.title }}</span>
                </div>

                <!-- Hero -->
                <div class="relative rounded-3xl overflow-hidden mb-10">
                    <div v-if="service.image" class="aspect-video">
                        <img :src="service.image" :alt="service.title" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    </div>
                    <div v-else class="aspect-video bg-gradient-to-br from-green-900/30 to-black flex items-center justify-center">
                        <div class="text-8xl opacity-30">🎙️</div>
                    </div>

                    <div class="absolute bottom-0 left-0 right-0 p-8">
                        <span class="text-xs font-semibold text-green-400 uppercase tracking-widest bg-green-500/10 border border-green-500/30 px-3 py-1 rounded-full">
                            {{ categoryLabels[service.category] }}
                        </span>
                        <h1 class="text-4xl md:text-5xl font-bold text-white mt-3">{{ service.title }}</h1>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Content -->
                    <div class="lg:col-span-2">
                        <p class="text-gray-300 text-lg leading-relaxed mb-8">{{ service.description }}</p>

                        <!-- Audio preview -->
                        <div v-if="service.audio_preview" class="mb-8 bg-green-900/10 border border-green-900/30 rounded-2xl p-6">
                            <h3 class="text-sm font-semibold text-green-400 uppercase tracking-wide mb-4">🎧 Écouter un extrait</h3>
                            <audio controls class="w-full accent-green-500">
                                <source :src="service.audio_preview">
                            </audio>
                        </div>

                        <!-- Long content -->
                        <div v-if="service.content" class="prose prose-invert prose-green max-w-none" v-html="service.content"></div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-24 bg-gray-900/60 border border-green-900/30 rounded-2xl p-6">
                            <div v-if="service.price" class="mb-6">
                                <span class="text-gray-400 text-sm">À partir de</span>
                                <div class="text-4xl font-bold text-green-400 mt-1">{{ service.price }} €</div>
                            </div>

                            <span v-if="service.is_premium" class="inline-block mb-4 text-xs bg-green-500/20 text-green-400 border border-green-500/30 px-3 py-1 rounded-full">
                                ⭐ Contenu Premium
                            </span>

                            <a
                                href="mailto:contact@multivoix.fr"
                                class="block w-full text-center py-3.5 bg-green-500 hover:bg-green-400 text-black font-bold rounded-xl transition-all duration-300 hover:scale-105 mb-3"
                            >
                                Demander un devis
                            </a>
                            <Link
                                href="/services"
                                class="block w-full text-center py-3 border border-green-900/40 hover:border-green-500/40 text-gray-400 hover:text-white rounded-xl transition-all duration-300 text-sm"
                            >
                                ← Tous les services
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
