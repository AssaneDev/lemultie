<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';

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
});

function submit() {
    props.meditation ? form.put(`/admin/meditations/${props.meditation.id}`) : form.post('/admin/meditations');
}

function autoSlug() {
    if (!props.meditation) {
        form.slug = form.title.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/[^a-z0-9\s-]/g, '').trim().replace(/\s+/g, '-');
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
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Titre *</label>
                    <input v-model="form.title" @input="autoSlug" type="text" required
                        class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                    <textarea v-model="form.description" rows="3"
                        class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none resize-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Type *</label>
                        <select v-model="form.type" class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none">
                            <option value="audio">Audio</option>
                            <option value="video">Vidéo</option>
                            <option value="both">Audio + Vidéo</option>
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
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Durée (secondes)</label>
                    <input v-model="form.duration_seconds" type="number" min="0"
                        class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none"
                        placeholder="Ex: 600 pour 10 min">
                </div>
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
