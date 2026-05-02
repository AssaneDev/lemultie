<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';

const props = defineProps({ formation: Object });

const form = useForm({
    title: props.formation?.title ?? '',
    slug: props.formation?.slug ?? '',
    description: props.formation?.description ?? '',
    content: props.formation?.content ?? '',
    price: props.formation?.price ?? '',
    level: props.formation?.level ?? 'debutant',
    duration_hours: props.formation?.duration_hours ?? '',
    max_students: props.formation?.max_students ?? '',
    is_active: props.formation?.is_active ?? true,
    is_premium: props.formation?.is_premium ?? false,
});

function submit() {
    props.formation ? form.put(`/admin/formations/${props.formation.id}`) : form.post('/admin/formations');
}

function autoSlug() {
    if (!props.formation) {
        form.slug = form.title.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/[^a-z0-9\s-]/g, '').trim().replace(/\s+/g, '-');
    }
}
</script>

<template>
    <AdminLayout>
        <template #header>
            <div class="flex items-center gap-3">
                <Link href="/admin/formations" class="text-gray-400 hover:text-white">← Formations</Link>
                <span class="text-gray-600">/</span>
                <h2 class="font-semibold text-xl text-gray-200">{{ formation ? 'Modifier' : 'Nouvelle formation' }}</h2>
            </div>
        </template>
        <div class="py-8 px-4 max-w-3xl mx-auto">
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Titre *</label>
                    <input v-model="form.title" @input="autoSlug" type="text" required
                        class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Description *</label>
                    <textarea v-model="form.description" rows="3" required
                        class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none resize-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Prix (€) *</label>
                        <input v-model="form.price" type="number" step="0.01" min="0" required
                            class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Niveau *</label>
                        <select v-model="form.level" class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none">
                            <option value="debutant">Débutant</option>
                            <option value="intermediaire">Intermédiaire</option>
                            <option value="avance">Avancé</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Durée (heures)</label>
                        <input v-model="form.duration_hours" type="number" min="0"
                            class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Max étudiants</label>
                        <input v-model="form.max_students" type="number" min="0"
                            class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Contenu détaillé</label>
                    <textarea v-model="form.content" rows="8"
                        class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none resize-y font-mono text-sm"></textarea>
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
                        {{ form.processing ? 'Enregistrement...' : (formation ? 'Mettre à jour' : 'Créer') }}
                    </button>
                    <Link href="/admin/formations" class="text-gray-400 hover:text-white text-sm">Annuler</Link>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
