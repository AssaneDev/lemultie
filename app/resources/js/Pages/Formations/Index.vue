<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    formations: Array,
});

const levelLabels = {
    debutant: 'Débutant',
    intermediaire: 'Intermédiaire',
    avance: 'Avancé',
};

const levelColors = {
    debutant: 'text-green-400 border-green-400/30 bg-green-400/10',
    intermediaire: 'text-yellow-400 border-yellow-400/30 bg-yellow-400/10',
    avance: 'text-red-400 border-red-400/30 bg-red-400/10',
};
</script>

<template>
    <AppLayout>
        <div class="py-20 px-4">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-16">
                    <span class="text-green-400 text-sm font-semibold uppercase tracking-widest">Apprendre & progresser</span>
                    <h1 class="text-5xl font-bold text-white mt-3 mb-4">Formations</h1>
                    <div class="w-16 h-1 bg-green-500 mx-auto rounded-full"></div>
                    <p class="text-gray-400 mt-6 max-w-2xl mx-auto">
                        Oralité, rythmique, expression — développez vos compétences avec des formations en ligne et en présentiel.
                    </p>
                </div>

                <!-- Grid -->
                <div v-if="formations?.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <Link
                        v-for="formation in formations"
                        :key="formation.id"
                        :href="`/formations/${formation.slug}`"
                        class="group bg-gray-900/40 border border-green-900/20 rounded-2xl overflow-hidden hover:border-green-500/40 transition-all duration-300 hover:-translate-y-1"
                    >
                        <div class="aspect-video bg-gradient-to-br from-green-900/30 to-black overflow-hidden relative">
                            <img v-if="formation.image" :src="formation.image" :alt="formation.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div v-else class="absolute inset-0 flex items-center justify-center text-5xl">🎓</div>
                            <span :class="`absolute top-3 left-3 text-xs font-semibold border px-2 py-1 rounded-full ${levelColors[formation.level]}`">
                                {{ levelLabels[formation.level] }}
                            </span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-3 group-hover:text-green-400 transition-colors line-clamp-2">
                                {{ formation.title }}
                            </h3>
                            <p class="text-gray-400 text-sm line-clamp-2 mb-4">{{ formation.description }}</p>
                            <div class="flex items-center justify-between">
                                <div class="text-gray-500 text-xs space-x-3">
                                    <span v-if="formation.duration_hours">⏱ {{ formation.duration_hours }}h</span>
                                </div>
                                <span class="text-xl font-bold text-green-400">{{ formation.price }} €</span>
                            </div>
                            <button class="mt-4 w-full py-2.5 bg-green-500/10 border border-green-500/30 hover:bg-green-500 hover:text-black text-green-400 font-semibold rounded-xl transition-all duration-300 text-sm">
                                Voir la formation
                            </button>
                        </div>
                    </Link>
                </div>

                <div v-else class="text-center py-20">
                    <div class="text-6xl mb-4">🎓</div>
                    <h3 class="text-xl font-semibold text-white mb-2">Formations bientôt disponibles</h3>
                    <p class="text-gray-500">Inscrivez-vous pour être notifié au lancement.</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
