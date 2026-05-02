<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    articles: Array,
});

function formatDate(date) {
    return new Date(date).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' });
}
</script>

<template>
    <AppLayout>
        <div class="py-20 px-4">
            <div class="max-w-5xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-16">
                    <span class="text-green-400 text-sm font-semibold uppercase tracking-widest">Pensées & inspirations</span>
                    <h1 class="text-5xl font-bold text-white mt-3 mb-4">Blog</h1>
                    <div class="w-16 h-1 bg-green-500 mx-auto rounded-full"></div>
                </div>

                <!-- Articles -->
                <div v-if="articles?.length" class="space-y-8">
                    <Link
                        v-for="article in articles"
                        :key="article.id"
                        :href="`/blog/${article.slug}`"
                        class="group flex flex-col md:flex-row gap-6 bg-gray-900/40 border border-green-900/20 rounded-2xl overflow-hidden hover:border-green-500/30 transition-all duration-300"
                    >
                        <div class="md:w-64 flex-shrink-0 bg-gradient-to-br from-green-900/30 to-black aspect-video md:aspect-auto overflow-hidden">
                            <img v-if="article.image" :src="article.image" :alt="article.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div v-else class="w-full h-full flex items-center justify-center text-4xl">✍️</div>
                        </div>
                        <div class="p-6 flex flex-col justify-center">
                            <span class="text-xs text-gray-500 mb-2">{{ formatDate(article.published_at) }}</span>
                            <h2 class="text-2xl font-bold text-white mb-3 group-hover:text-green-400 transition-colors">
                                {{ article.title }}
                            </h2>
                            <p v-if="article.excerpt" class="text-gray-400 text-sm line-clamp-3 mb-4">{{ article.excerpt }}</p>
                            <div class="flex items-center gap-3">
                                <span class="text-green-400 text-sm font-medium group-hover:underline">Lire l'article →</span>
                                <span v-if="article.is_premium" class="text-xs bg-green-500/20 text-green-400 border border-green-500/30 px-2 py-0.5 rounded-full">Premium</span>
                            </div>
                        </div>
                    </Link>
                </div>

                <div v-else class="text-center py-20">
                    <div class="text-6xl mb-4">✍️</div>
                    <h3 class="text-xl font-semibold text-white mb-2">Articles bientôt disponibles</h3>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
