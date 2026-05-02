<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    article: Object,
});

function formatDate(date) {
    return new Date(date).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' });
}
</script>

<template>
    <AppLayout>
        <div class="py-20 px-4">
            <div class="max-w-3xl mx-auto">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-8">
                    <Link :href="article.type === 'conference' ? '/conferences' : '/blog'"
                        class="hover:text-green-400 transition-colors">
                        {{ article.type === 'conference' ? 'Conférences' : 'Blog' }}
                    </Link>
                    <span>/</span>
                    <span class="text-gray-300 truncate max-w-xs">{{ article.title }}</span>
                </div>

                <!-- Header -->
                <div class="mb-8">
                    <span class="inline-block text-xs font-semibold text-green-400 uppercase tracking-widest bg-green-500/10 border border-green-500/30 px-3 py-1 rounded-full mb-4">
                        {{ article.type === 'conference' ? '🎤 Conférence' : '✍️ Article' }}
                    </span>
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight">{{ article.title }}</h1>
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <span v-if="article.author">Par {{ article.author.name }}</span>
                        <span v-if="article.published_at">{{ formatDate(article.published_at) }}</span>
                        <span v-if="article.is_premium" class="text-green-400 font-medium">⭐ Premium</span>
                    </div>
                </div>

                <!-- Cover image -->
                <div v-if="article.image" class="rounded-2xl overflow-hidden aspect-video mb-10">
                    <img :src="article.image" :alt="article.title" class="w-full h-full object-cover">
                </div>

                <!-- Video -->
                <div v-if="article.video_url" class="rounded-2xl overflow-hidden aspect-video mb-10">
                    <iframe :src="article.video_url" class="w-full h-full" allowfullscreen></iframe>
                </div>

                <!-- Excerpt -->
                <p v-if="article.excerpt" class="text-xl text-gray-300 leading-relaxed border-l-4 border-green-500 pl-6 mb-10 italic">
                    {{ article.excerpt }}
                </p>

                <!-- Content -->
                <div class="prose prose-invert prose-green max-w-none prose-p:text-gray-300 prose-headings:text-white prose-a:text-green-400"
                    v-html="article.content">
                </div>

                <!-- Back -->
                <div class="mt-12 pt-8 border-t border-green-900/20">
                    <Link
                        :href="article.type === 'conference' ? '/conferences' : '/blog'"
                        class="text-green-400 hover:text-green-300 transition-colors"
                    >
                        ← Retour au {{ article.type === 'conference' ? 'conférences' : 'blog' }}
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
