<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import AudioPlayer from '@/Components/AudioPlayer.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    meditation: Object,
});

const themeLabels = {
    relaxation: 'Relaxation',
    sommeil: 'Sommeil',
    concentration: 'Concentration',
    energie: 'Énergie',
    guerison: 'Guérison',
    autre: 'Autre',
};

function formatDuration(seconds) {
    if (!seconds) return '';
    const m = Math.floor(seconds / 60);
    const s = seconds % 60;
    return `${m} min ${s > 0 ? s + ' sec' : ''}`;
}
</script>

<template>
    <AppLayout>
        <div class="py-20 px-4">
            <div class="max-w-3xl mx-auto">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-8">
                    <Link href="/meditations" class="hover:text-green-400 transition-colors">Méditations</Link>
                    <span>/</span>
                    <span class="text-gray-300">{{ meditation.title }}</span>
                </div>

                <!-- Header -->
                <div class="text-center mb-10">
                    <span class="inline-block text-xs font-semibold text-green-400 uppercase tracking-widest bg-green-500/10 border border-green-500/30 px-3 py-1 rounded-full mb-4">
                        {{ themeLabels[meditation.theme] }}
                    </span>
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ meditation.title }}</h1>
                    <div class="flex items-center justify-center gap-4 text-sm text-gray-500">
                        <span v-if="meditation.duration_seconds">⏱ {{ formatDuration(meditation.duration_seconds) }}</span>
                        <span>👂 {{ meditation.listen_count }} écoutes</span>
                        <span v-if="meditation.is_premium" class="text-green-400">⭐ Premium</span>
                    </div>
                </div>

                <!-- Thumbnail -->
                <div v-if="meditation.thumbnail" class="rounded-2xl overflow-hidden mb-8 aspect-video">
                    <img :src="meditation.thumbnail" :alt="meditation.title" class="w-full h-full object-cover">
                </div>
                <div v-else class="rounded-2xl bg-gradient-to-br from-green-900/20 to-black aspect-video flex items-center justify-center mb-8">
                    <div class="text-center">
                        <div class="text-8xl mb-4 opacity-20">🧘</div>
                        <div class="w-16 h-1 bg-green-500/30 mx-auto rounded-full"></div>
                    </div>
                </div>

                <!-- Audio Player -->
                <div v-if="meditation.audio_file || meditation.type !== 'video'" class="mb-8">
                    <AudioPlayer
                        :src="meditation.audio_file"
                        :title="meditation.title"
                    />
                </div>

                <!-- Video -->
                <div v-if="meditation.video_file && (meditation.type === 'video' || meditation.type === 'both')" class="mb-8 rounded-2xl overflow-hidden">
                    <video controls class="w-full rounded-2xl" :poster="meditation.thumbnail">
                        <source :src="meditation.video_file">
                    </video>
                </div>

                <!-- Description -->
                <div v-if="meditation.description" class="bg-green-900/10 border border-green-900/20 rounded-2xl p-6">
                    <p class="text-gray-300 leading-relaxed">{{ meditation.description }}</p>
                </div>

                <!-- Navigation -->
                <div class="mt-10 text-center">
                    <Link href="/meditations" class="text-green-400 hover:text-green-300 transition-colors">
                        ← Toutes les méditations
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
