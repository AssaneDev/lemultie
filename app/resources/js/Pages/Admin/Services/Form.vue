<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AiWriter from '@/Components/AiWriter.vue';
import { useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    service: Object,
});

const form = useForm({
    title: props.service?.title ?? '',
    slug: props.service?.slug ?? '',
    description: props.service?.description ?? '',
    content: props.service?.content ?? '',
    category: props.service?.category ?? 'copywriting',
    price: props.service?.price ?? '',
    is_active: props.service?.is_active ?? true,
    is_premium: props.service?.is_premium ?? false,
    order: props.service?.order ?? 0,
});

function submit() {
    if (props.service) {
        form.put(`/admin/services/${props.service.id}`);
    } else {
        form.post('/admin/services');
    }
}

function autoSlug() {
    if (!props.service) {
        form.slug = form.title
            .toLowerCase()
            .normalize('NFD').replace(/[̀-ͯ]/g, '')
            .replace(/[^a-z0-9\s-]/g, '')
            .trim().replace(/\s+/g, '-');
    }
}
</script>

<template>
    <AdminLayout>
        <template #header>
            <div class="flex items-center gap-3">
                <Link href="/admin/services" class="text-gray-400 hover:text-white">← Services</Link>
                <span class="text-gray-600">/</span>
                <h2 class="font-semibold text-xl text-gray-200">{{ service ? 'Modifier' : 'Nouveau service' }}</h2>
            </div>
        </template>

        <div class="py-8 px-4 max-w-3xl mx-auto">
            <form @submit.prevent="submit" class="space-y-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Titre *</label>
                        <input v-model="form.title" @input="autoSlug" type="text" required
                            class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none transition-colors"
                            placeholder="Nom du service">
                        <p v-if="form.errors.title" class="text-red-400 text-sm mt-1">{{ form.errors.title }}</p>
                    </div>

                    <!-- Slug -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Slug (URL)</label>
                        <input v-model="form.slug" type="text"
                            class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-gray-400 focus:border-green-500 focus:outline-none transition-colors font-mono text-sm"
                            placeholder="url-du-service">
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Catégorie *</label>
                        <select v-model="form.category" required
                            class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none">
                            <option value="copywriting">Copywriting</option>
                            <option value="voix_off">Voix Off</option>
                            <option value="percussion">Percussions</option>
                            <option value="conte">Contes & Storytelling</option>
                            <option value="meditation">Méditations</option>
                            <option value="formation">Formations</option>
                            <option value="conference">Conférences</option>
                        </select>
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Prix (€)</label>
                        <input v-model="form.price" type="number" step="0.01" min="0"
                            class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none"
                            placeholder="0.00">
                    </div>
                </div>

                <!-- Description -->
                <AiWriter v-model="form.description" field-label="description courte de service" :context="form.title" :rows="3">
                    <template #label>
                        <label class="block text-sm font-medium text-gray-300">Description courte *</label>
                    </template>
                </AiWriter>

                <!-- Content -->
                <AiWriter v-model="form.content" field-label="contenu détaillé de service" :context="form.title" :rows="8">
                    <template #label>
                        <label class="block text-sm font-medium text-gray-300">Contenu détaillé</label>
                    </template>
                </AiWriter>

                <!-- Toggles -->
                <div class="flex gap-8">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" v-model="form.is_active" class="w-5 h-5 accent-green-500 rounded">
                        <span class="text-gray-300 text-sm">Service actif</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" v-model="form.is_premium" class="w-5 h-5 accent-green-500 rounded">
                        <span class="text-gray-300 text-sm">Contenu premium</span>
                    </label>
                </div>

                <!-- Submit -->
                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" :disabled="form.processing"
                        class="px-8 py-3 bg-green-500 hover:bg-green-400 disabled:opacity-50 text-black font-bold rounded-xl transition-all duration-300">
                        {{ form.processing ? 'Enregistrement...' : (service ? 'Mettre à jour' : 'Créer le service') }}
                    </button>
                    <Link href="/admin/services" class="text-gray-400 hover:text-white text-sm">Annuler</Link>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
