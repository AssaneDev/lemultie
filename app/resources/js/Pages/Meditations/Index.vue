<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    meditations: Array,
    themes: Array,
});

const activeTheme = ref('');
const activeType = ref('');

const themeLabels = {
    relaxation: 'Relaxation',
    sommeil: 'Sommeil',
    concentration: 'Concentration',
    energie: 'Énergie',
    guerison: 'Guérison',
    autre: 'Autre',
};

function filter() {
    router.get('/meditations', {
        theme: activeTheme.value || undefined,
        type: activeType.value || undefined,
    }, { preserveState: true });
}

function formatDuration(seconds) {
    if (!seconds) return '';
    const m = Math.floor(seconds / 60);
    const s = seconds % 60;
    return `${m}:${s.toString().padStart(2, '0')}`;
}
</script>

<template>
    <AppLayout>
        <div class="py-20 px-4">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-12">
                    <span class="text-green-400 text-sm font-semibold uppercase tracking-widest">Plénitude & sérénité</span>
                    <h1 class="text-5xl font-bold text-white mt-3 mb-4">Méditations guidées</h1>
                    <div class="w-16 h-1 bg-green-500 mx-auto rounded-full"></div>
                </div>

                <!-- Filters -->
                <div class="flex flex-wrap gap-3 justify-center mb-12">
                    <button
                        @click="activeTheme = ''; filter()"
                        :class="[
                            'px-4 py-2 rounded-full text-sm font-medium transition-all',
                            !activeTheme ? 'bg-green-500 text-black' : 'border border-green-900/40 text-gray-400 hover:border-green-500/50 hover:text-white'
                        ]"
                    >
                        Tous
                    </button>
                    <button
                        v-for="theme in themes"
                        :key="theme"
                        @click="activeTheme = theme; filter()"
                        :class="[
                            'px-4 py-2 rounded-full text-sm font-medium transition-all',
                            activeTheme === theme ? 'bg-green-500 text-black' : 'border border-green-900/40 text-gray-400 hover:border-green-500/50 hover:text-white'
                        ]"
                    >
                        {{ themeLabels[theme] || theme }}
                    </button>
                </div>

                <!-- Grid -->
                <div v-if="meditations?.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <Link
                        v-for="meditation in meditations"
                        :key="meditation.id"
                        :href="`/meditations/${meditation.slug}`"
                        class="group bg-gray-900/40 border border-green-900/20 rounded-2xl overflow-hidden hover:border-green-500/40 transition-all duration-300 hover:-translate-y-1"
                    >
                        <div class="relative aspect-video bg-gradient-to-br from-green-900/30 to-black flex items-center justify-center overflow-hidden">
                            <img v-if="meditation.thumbnail" :src="meditation.thumbnail" :alt="meditation.title" class="w-full h-full object-cover absolute inset-0 opacity-60">
                            <!-- Play button -->
                            <div class="relative z-10 w-14 h-14 bg-green-500/80 rounded-full flex items-center justify-center group-hover:bg-green-400 transition-colors">
                                <svg class="w-6 h-6 text-black ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                            <!-- Duration badge -->
                            <span v-if="meditation.duration_seconds" class="absolute bottom-3 right-3 bg-black/70 text-white text-xs px-2 py-1 rounded">
                                {{ formatDuration(meditation.duration_seconds) }}
                            </span>
                            <!-- Type badge -->
                            <span class="absolute top-3 left-3 bg-green-500/20 text-green-400 border border-green-500/30 text-xs px-2 py-1 rounded-full">
                                {{ meditation.type === 'audio' ? '🎧 Audio' : meditation.type === 'video' ? '📹 Vidéo' : '🎧📹 Les deux' }}
                            </span>
                        </div>
                        <div class="p-5">
                            <span class="text-xs font-medium text-green-400 uppercase tracking-wide">
                                {{ themeLabels[meditation.theme] || meditation.theme }}
                            </span>
                            <h3 class="text-lg font-bold text-white mt-1 mb-2 group-hover:text-green-400 transition-colors">
                                {{ meditation.title }}
                            </h3>
                            <p v-if="meditation.description" class="text-gray-500 text-sm line-clamp-2">
                                {{ meditation.description }}
                            </p>
                            <div class="mt-3 flex items-center justify-between text-xs text-gray-600">
                                <span>{{ meditation.listen_count }} écoutes</span>
                                <span v-if="meditation.is_premium" class="text-green-500">Premium</span>
                            </div>
                        </div>
                    </Link>
                </div>

                <div v-else class="text-center py-20">
                    <div class="text-6xl mb-4">🧘</div>
                    <h3 class="text-xl font-semibold text-white mb-2">Méditations bientôt disponibles</h3>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
