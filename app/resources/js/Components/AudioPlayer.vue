<script setup>
import { ref, computed, watch, onUnmounted } from 'vue';

const props = defineProps({
    src: String,
    title: String,
    autoplay: { type: Boolean, default: false },
});

const audio = ref(null);
const isPlaying = ref(false);
const currentTime = ref(0);
const duration = ref(0);
const volume = ref(1);
const isLoading = ref(false);

const progress = computed(() => duration.value ? (currentTime.value / duration.value) * 100 : 0);

function formatTime(s) {
    if (!s || isNaN(s)) return '0:00';
    const m = Math.floor(s / 60);
    const sec = Math.floor(s % 60);
    return `${m}:${sec.toString().padStart(2, '0')}`;
}

function togglePlay() {
    if (!audio.value) return;
    if (isPlaying.value) {
        audio.value.pause();
    } else {
        audio.value.play();
    }
}

function seek(e) {
    if (!audio.value || !duration.value) return;
    const rect = e.currentTarget.getBoundingClientRect();
    const ratio = (e.clientX - rect.left) / rect.width;
    audio.value.currentTime = ratio * duration.value;
}

function setVolume(e) {
    volume.value = parseFloat(e.target.value);
    if (audio.value) audio.value.volume = volume.value;
}

function onTimeUpdate() {
    currentTime.value = audio.value?.currentTime ?? 0;
}

function onLoadedMetadata() {
    duration.value = audio.value?.duration ?? 0;
    isLoading.value = false;
}

function onEnded() {
    isPlaying.value = false;
    currentTime.value = 0;
}

function onWaiting() { isLoading.value = true; }
function onCanPlay() { isLoading.value = false; }

watch(() => props.src, () => {
    isPlaying.value = false;
    currentTime.value = 0;
    duration.value = 0;
});

onUnmounted(() => {
    audio.value?.pause();
});
</script>

<template>
    <div class="bg-gray-900/80 border border-green-900/30 rounded-2xl p-5 backdrop-blur-sm">
        <audio
            ref="audio"
            :src="src"
            :autoplay="autoplay"
            @timeupdate="onTimeUpdate"
            @loadedmetadata="onLoadedMetadata"
            @ended="onEnded"
            @play="isPlaying = true"
            @pause="isPlaying = false"
            @waiting="onWaiting"
            @canplay="onCanPlay"
        />

        <!-- Title -->
        <div v-if="title" class="text-sm font-medium text-gray-300 mb-4 truncate">
            🎧 {{ title }}
        </div>

        <!-- Waveform progress bar -->
        <div
            class="relative h-10 bg-gray-800 rounded-xl overflow-hidden cursor-pointer mb-4 group"
            @click="seek"
        >
            <!-- Fake waveform bars -->
            <div class="absolute inset-0 flex items-center gap-px px-1">
                <div
                    v-for="i in 60"
                    :key="i"
                    :style="{ height: `${20 + Math.sin(i * 0.5) * 15 + Math.random() * 10}px` }"
                    :class="[
                        'flex-1 rounded-sm transition-colors duration-100',
                        (i / 60) * 100 <= progress ? 'bg-green-500' : 'bg-gray-600 group-hover:bg-gray-500'
                    ]"
                ></div>
            </div>
        </div>

        <!-- Controls -->
        <div class="flex items-center gap-4">
            <!-- Play/Pause -->
            <button
                @click="togglePlay"
                class="w-12 h-12 bg-green-500 hover:bg-green-400 rounded-full flex items-center justify-center transition-all duration-200 hover:scale-105 flex-shrink-0"
            >
                <svg v-if="isLoading" class="w-5 h-5 text-black animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                <svg v-else-if="isPlaying" class="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                </svg>
                <svg v-else class="w-5 h-5 text-black ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>
            </button>

            <!-- Time -->
            <div class="text-xs text-gray-400 font-mono w-20 flex-shrink-0">
                {{ formatTime(currentTime) }} / {{ formatTime(duration) }}
            </div>

            <!-- Volume -->
            <div class="flex items-center gap-2 ml-auto">
                <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/>
                </svg>
                <input
                    type="range"
                    min="0"
                    max="1"
                    step="0.01"
                    :value="volume"
                    @input="setVolume"
                    class="w-16 accent-green-500 cursor-pointer"
                />
            </div>
        </div>
    </div>
</template>
