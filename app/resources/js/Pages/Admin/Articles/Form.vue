<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AiWriter from '@/Components/AiWriter.vue';
import { useForm, Link } from '@inertiajs/vue3';

const props = defineProps({ article: Object });

const form = useForm({
    title: props.article?.title ?? '',
    slug: props.article?.slug ?? '',
    excerpt: props.article?.excerpt ?? '',
    content: props.article?.content ?? '',
    type: props.article?.type ?? 'article',
    is_published: props.article?.is_published ?? false,
    is_premium: props.article?.is_premium ?? false,
});

function submit() {
    props.article ? form.put(`/admin/articles/${props.article.id}`) : form.post('/admin/articles');
}

function autoSlug() {
    if (!props.article) {
        form.slug = form.title.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/[^a-z0-9\s-]/g, '').trim().replace(/\s+/g, '-');
    }
}
</script>

<template>
    <AdminLayout>
        <template #header>
            <div class="flex items-center gap-3">
                <Link href="/admin/articles" class="text-gray-400 hover:text-white">← Articles</Link>
                <span class="text-gray-600">/</span>
                <h2 class="font-semibold text-xl text-gray-200">{{ article ? 'Modifier' : 'Nouvel article' }}</h2>
            </div>
        </template>
        <div class="py-8 px-4 max-w-3xl mx-auto">
            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Titre *</label>
                        <input v-model="form.title" @input="autoSlug" type="text" required
                            class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Type *</label>
                        <select v-model="form.type" class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none">
                            <option value="article">Article</option>
                            <option value="conference">Conférence</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Slug (URL)</label>
                        <input v-model="form.slug" type="text"
                            class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-gray-400 focus:border-green-500 focus:outline-none font-mono text-sm">
                    </div>
                </div>
                <AiWriter v-model="form.excerpt" field-label="extrait / résumé d'article" :context="form.title" :rows="2">
                    <template #label>
                        <label class="block text-sm font-medium text-gray-300">Extrait / Résumé</label>
                    </template>
                </AiWriter>
                <AiWriter v-model="form.content" field-label="contenu complet d'article" :context="form.title" :rows="12">
                    <template #label>
                        <label class="block text-sm font-medium text-gray-300">Contenu * <span class="text-gray-500 font-normal">(HTML accepté)</span></label>
                    </template>
                </AiWriter>
                <div class="flex gap-8">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" v-model="form.is_published" class="w-5 h-5 accent-green-500">
                        <span class="text-gray-300 text-sm">Publier maintenant</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" v-model="form.is_premium" class="w-5 h-5 accent-green-500">
                        <span class="text-gray-300 text-sm">Premium</span>
                    </label>
                </div>
                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" :disabled="form.processing"
                        class="px-8 py-3 bg-green-500 hover:bg-green-400 disabled:opacity-50 text-black font-bold rounded-xl transition-all">
                        {{ form.processing ? 'Enregistrement...' : (article ? 'Mettre à jour' : 'Créer') }}
                    </button>
                    <Link href="/admin/articles" class="text-gray-400 hover:text-white text-sm">Annuler</Link>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
