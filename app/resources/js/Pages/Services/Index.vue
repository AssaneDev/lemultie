<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    services: Array,
});

const categories = {
    copywriting: { label: 'Copywriting', icon: '✍️' },
    voix_off: { label: 'Voix Off', icon: '🎙️' },
    percussion: { label: 'Percussions', icon: '🥁' },
    conte: { label: 'Contes', icon: '📖' },
    meditation: { label: 'Méditations', icon: '🧘' },
    formation: { label: 'Formations', icon: '🎓' },
    conference: { label: 'Conférences', icon: '🎤' },
};
</script>

<template>
    <AppLayout>
        <div class="py-20 px-4">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-16">
                    <span class="text-green-400 text-sm font-semibold uppercase tracking-widest">Tout ce que je propose</span>
                    <h1 class="text-5xl font-bold text-white mt-3 mb-4">Mes services</h1>
                    <div class="w-16 h-1 bg-green-500 mx-auto rounded-full"></div>
                    <p class="text-gray-400 mt-6 max-w-2xl mx-auto">
                        De la voix à la plume, du rythme à l'écoute — découvrez l'ensemble des prestations Multi-Voix.
                    </p>
                </div>

                <!-- Services grid -->
                <div v-if="services?.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <Link
                        v-for="service in services"
                        :key="service.id"
                        :href="`/services/${service.slug}`"
                        class="group bg-gray-900/50 border border-green-900/20 rounded-2xl overflow-hidden hover:border-green-500/40 transition-all duration-300 hover:-translate-y-1"
                    >
                        <div v-if="service.image" class="aspect-video overflow-hidden">
                            <img :src="service.image" :alt="service.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div v-else class="aspect-video bg-gradient-to-br from-green-900/20 to-black flex items-center justify-center">
                            <span class="text-5xl">{{ categories[service.category]?.icon }}</span>
                        </div>
                        <div class="p-6">
                            <span class="text-xs font-semibold text-green-400 uppercase tracking-wide">
                                {{ categories[service.category]?.label }}
                            </span>
                            <h3 class="text-xl font-bold text-white mt-2 mb-3 group-hover:text-green-400 transition-colors">
                                {{ service.title }}
                            </h3>
                            <p class="text-gray-400 text-sm line-clamp-2">{{ service.description }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <span v-if="service.price" class="text-green-400 font-bold">
                                    {{ service.price }} €
                                </span>
                                <span v-if="service.is_premium" class="text-xs bg-green-500/20 text-green-400 border border-green-500/30 px-2 py-1 rounded-full">
                                    Premium
                                </span>
                            </div>
                        </div>
                    </Link>
                </div>

                <!-- Empty state -->
                <div v-else class="text-center py-20">
                    <div class="text-6xl mb-4">🎙️</div>
                    <h3 class="text-xl font-semibold text-white mb-2">Services bientôt disponibles</h3>
                    <p class="text-gray-500">Revenez très prochainement.</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
