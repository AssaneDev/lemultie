<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AiWriter from '@/Components/AiWriter.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({ meditation: Object });

const form = useForm({
    title: props.meditation?.title ?? '',
    slug: props.meditation?.slug ?? '',
    description: props.meditation?.description ?? '',
    type: props.meditation?.type ?? 'audio',
    theme: props.meditation?.theme ?? 'relaxation',
    duration_seconds: props.meditation?.duration_seconds ?? '',
    is_active: props.meditation?.is_active ?? true,
    is_premium: props.meditation?.is_premium ?? false,
    youtube_url: props.meditation?.youtube_url ?? '',
    audio_file: null,
});

const audioFileName = ref('');
const showAudio = computed(() => form.type === 'audio' || form.type === 'both');
const showVideo = computed(() => form.type === 'video' || form.type === 'both');

const youtubeEmbedId = computed(() => {
    const url = form.youtube_url;
    if (!url) return null;
    const match = url.match(/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
    return match ? match[1] : null;
});

function onAudioChange(e) {
    const file = e.target.files[0];
    if (file) {
        form.audio_file = file;
        audioFileName.value = file.name;
    }
}

function submit() {
    if (props.meditation) {
        form.post(`/admin/meditations/${props.meditation.id}`, {
            method: 'put',
            forceFormData: true,
        });
    } else {
        form.post('/admin/meditations', { forceFormData: true });
    }
}

function autoSlug() {
    if (!props.meditation) {
        form.slug = form.title.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^a-z0-9\s-]/g, '').trim().replace(/\s+/g, '-');
    }
}
</script>

<template>
    <AdminLayout>
        <template #header>
            <div class="flex items-center gap-3">
                <Link href="/admin/meditations" class="text-gray-400 hover:text-white">← Méditations</Link>
                <span class="text-gray-600">/</span>
                <h2 class="font-semibold text-xl text-gray-200">{{ meditation ? 'Modifier' : 'Nouvelle méditation' }}</h2>
            </div>
        </template>

        <div class="py-8 px-4 max-w-2xl mx-auto">
            <form @submit.prevent="submit" class="space-y-6">

                <!-- Titre -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Titre *</label>
                    <input v-model="form.title" @input="autoSlug" type="text" required
                        class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none">
                    <p v-if="form.errors.title" class="text-red-400 text-xs mt-1">{{ form.errors.title }}</p>
                </div>

                <!-- Description -->
                <AiWriter v-model="form.description" field-label="description de méditation" :context="form.title" :rows="3">
                    <template #label>
                        <label class="block text-sm font-medium text-gray-300">Description</label>
                    </template>
                </AiWriter>

                <!-- Type + Thème -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Type *</label>
                        <select v-model="form.type" class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none">
                            <option value="audio">🎵 Audio</option>
                            <option value="video">▶️ Vidéo YouTube</option>
                            <option value="both">🎵▶️ Audio + Vidéo</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Thème *</label>
                        <select v-model="form.theme" class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none">
                            <option value="relaxation">Relaxation</option>
                            <option value="sommeil">Sommeil</option>
                            <option value="concentration">Concentration</option>
                            <option value="energie">Énergie</option>
                            <option value="guerison">Guérison</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                </div>

                <!-- YouTube URL -->
                <div v-if="showVideo" class="space-y-3">
                    <label class="block text-sm font-medium text-gray-300">URL YouTube *</label>
                    <input v-model="form.youtube_url" type="url" placeholder="https://www.youtube.com/watch?v=..."
                        class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none placeholder-gray-600">
                    <p v-if="form.errors.youtube_url" class="text-red-400 text-xs">{{ form.errors.youtube_url }}</p>

                    <!-- Preview YouTube -->
                    <div v-if="youtubeEmbedId" class="rounded-xl overflow-hidden aspect-video">
                        <iframe
                            :src="`https://www.youtube.com/embed/${youtubeEmbedId}`"
                            class="w-full h-full"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                        ></iframe>
                    </div>
                    <p v-else-if="form.youtube_url" class="text-yellow-400 text-xs">URL YouTube invalide</p>
                </div>

                <!-- Audio Upload -->
                <div v-if="showAudio" class="space-y-2">
                    <label class="block text-sm font-medium text-gray-300">Fichier audio (mp3, ogg, wav, m4a — max 100 Mo)</label>
                    <label class="flex items-center gap-4 bg-gray-800 border border-dashed border-gray-600 hover:border-green-500 rounded-xl px-4 py-4 cursor-pointer transition-colors">
                        <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                        </div>
                        <div class="text-sm">
                            <p class="text-green-400 font-medium">{{ audioFileName || (meditation?.audio_file ? 'Remplacer le fichier' : 'Choisir un fichier audio') }}</p>
                            <p v-if="meditation?.audio_file && !audioFileName" class="text-gray-500 text-xs mt-0.5">Fichier actuel présent</p>
                            <p v-else class="text-gray-500 text-xs mt-0.5">Laisser vide pour ne pas modifier</p>
                        </div>
                        <input type="file" accept=".mp3,.ogg,.wav,.m4a" class="hidden" @change="onAudioChange">
                    </label>
                    <p v-if="form.errors.audio_file" class="text-red-400 text-xs">{{ form.errors.audio_file }}</p>
                </div>

                <!-- Durée -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Durée (secondes)</label>
                    <input v-model="form.duration_seconds" type="number" min="0"
                        class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none"
                        placeholder="Ex: 600 pour 10 min">
                </div>

                <!-- Flags -->
                <div class="flex gap-8">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" v-model="form.is_active" class="w-5 h-5 accent-green-500">
                        <span class="text-gray-300 text-sm">Active</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" v-model="form.is_premium" class="w-5 h-5 accent-green-500">
                        <span class="text-gray-300 text-sm">Premium</span>
                    </label>
                </div>

                <!-- Submit -->
                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" :disabled="form.processing"
                        class="px-8 py-3 bg-green-500 hover:bg-green-400 disabled:opacity-50 text-black font-bold rounded-xl transition-all">
                        {{ form.processing ? 'Enregistrement...' : (meditation ? 'Mettre à jour' : 'Créer') }}
                    </button>
                    <Link href="/admin/meditations" class="text-gray-400 hover:text-white text-sm">Annuler</Link>
                </div>

            </form>
        </div>
    </AdminLayout>
</template>
