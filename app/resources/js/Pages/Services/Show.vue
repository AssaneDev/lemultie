<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({ service: Object });

function parseText(text) {
    if (!text) return '';
    if (text.trim().startsWith('<')) return text;
    const lines = text.replace(/\\n/g, '\n').split('\n');
    let html = '';
    let inUl = false, inOl = false;
    function closeList() {
        if (inUl) { html += '</ul>'; inUl = false; }
        if (inOl) { html += '</ol>'; inOl = false; }
    }
    function inline(str) {
        return str.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>').replace(/\*(.+?)\*/g, '<em>$1</em>');
    }
    for (const rawLine of lines) {
        const line = rawLine.trim();
        if (!line) { closeList(); continue; }
        const olMatch = line.match(/^(\d+)\.\s+(.+)/);
        const ulMatch = line.match(/^[-*]\s+(.+)/);
        if (line.match(/^##\s+/)) { closeList(); html += `<h2>${inline(line.replace(/^##\s+/, ''))}</h2>`; }
        else if (line.match(/^###\s+/)) { closeList(); html += `<h3>${inline(line.replace(/^###\s+/, ''))}</h3>`; }
        else if (ulMatch) { if (!inUl) { closeList(); html += '<ul>'; inUl = true; } html += `<li>${inline(ulMatch[1])}</li>`; }
        else if (olMatch) { if (!inOl) { closeList(); html += '<ol>'; inOl = true; } html += `<li>${inline(olMatch[2])}</li>`; }
        else { closeList(); html += `<p>${inline(line)}</p>`; }
    }
    closeList();
    return html;
}

const parsedContent = computed(() => parseText(props.service.content))

const categoryLabels = {
    copywriting: 'Copywriting',
    voix_off:    'Voix Off',
    percussion:  'Percussions',
    conte:       'Contes & Storytelling',
    meditation:  'Méditations',
    formation:   'Formations',
    conference:  'Conférences',
};

const categoryIcons = {
    copywriting: '✍️',
    voix_off:    '🎙️',
    percussion:  '🥁',
    conte:       '📖',
    meditation:  '🧘',
    formation:   '🎓',
    conference:  '🎤',
};
</script>

<template>
    <AppLayout>
        <!-- Hero -->
        <div class="relative min-h-[60vh] flex items-end overflow-hidden">
            <div class="absolute inset-0">
                <!-- Base -->
                <div class="absolute inset-0 bg-[#030712]"></div>

                <!-- Photo de fond si disponible -->
                <img v-if="service.image" :src="service.image" :alt="service.title"
                    class="absolute inset-0 w-full h-full object-cover opacity-10">

                <!-- Grille de points -->
                <div class="absolute inset-0 opacity-[0.03]"
                    style="background-image: radial-gradient(circle, #22c55e 1px, transparent 1px); background-size: 32px 32px;"></div>

                <!-- Glow principal vert -->
                <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-green-500/10 rounded-full blur-[100px]"></div>

                <!-- Glows secondaires -->
                <div class="absolute top-20 -left-20 w-[400px] h-[400px] bg-emerald-600/8 rounded-full blur-[80px]"></div>
                <div class="absolute top-10 -right-10 w-[300px] h-[300px] bg-green-400/6 rounded-full blur-[60px]"></div>

                <!-- Ligne horizontale lumineuse -->
                <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-green-500/30 to-transparent"></div>

                <!-- Cercles décoratifs + icône catégorie -->
                <div class="absolute top-16 right-[12%] w-64 h-64 border border-green-500/8 rounded-full flex items-center justify-center">
                    <span class="text-8xl opacity-10 select-none">{{ categoryIcons[service.category] ?? '✨' }}</span>
                </div>
                <div class="absolute top-28 right-[12%] w-44 h-44 border border-green-500/5 rounded-full translate-x-10 translate-y-10"></div>

                <!-- Texture -->
                <div class="absolute inset-0 opacity-[0.015] mix-blend-overlay"
                    style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 256 256%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noise%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.9%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noise)%22 opacity=%221%22/%3E%3C/svg%3E'); background-size: 200px;"></div>

                <!-- Dégradé bas -->
                <div class="absolute bottom-0 left-0 right-0 h-40 bg-gradient-to-t from-black to-transparent"></div>
            </div>

            <div class="relative z-10 w-full max-w-5xl mx-auto px-4 pb-14 pt-32">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-xs text-gray-600 mb-6">
                    <Link href="/services" class="hover:text-green-400 transition-colors">Services</Link>
                    <span>/</span>
                    <span class="text-gray-400">{{ service.title }}</span>
                </div>

                <!-- Category badge -->
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-green-500/10 border border-green-500/20 rounded-full text-green-400 text-xs font-semibold uppercase tracking-widest mb-5">
                    <span>{{ categoryIcons[service.category] ?? '✨' }}</span>
                    {{ categoryLabels[service.category] }}
                </div>

                <!-- Title -->
                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight leading-tight mb-5 max-w-3xl">
                    {{ service.title }}
                </h1>

                <!-- Description lead -->
                <p class="text-lg text-gray-400 leading-relaxed max-w-2xl">
                    {{ service.description }}
                </p>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-5xl mx-auto px-4 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                <!-- Main -->
                <div class="lg:col-span-2 space-y-10">

                    <!-- Audio preview -->
                    <div v-if="service.audio_preview"
                        class="bg-green-900/10 border border-green-900/30 rounded-2xl p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center text-green-400 text-sm">🎧</div>
                            <h3 class="text-sm font-semibold text-green-400 uppercase tracking-widest">Écouter un extrait</h3>
                        </div>
                        <audio controls class="w-full accent-green-500">
                            <source :src="service.audio_preview">
                        </audio>
                    </div>

                    <!-- Long content -->
                    <div v-if="service.content"
                        class="bg-gray-950/60 border border-gray-800/60 rounded-2xl p-8">
                        <div class="prose prose-invert prose-green max-w-none
                            prose-h2:text-2xl prose-h2:font-black prose-h2:text-white prose-h2:mt-8 prose-h2:mb-4
                            prose-h3:text-lg prose-h3:font-bold prose-h3:text-green-400 prose-h3:mt-6 prose-h3:mb-3
                            prose-p:text-gray-300 prose-p:leading-loose prose-p:text-base prose-p:mb-4
                            prose-strong:text-white prose-strong:font-bold
                            prose-li:text-gray-300 prose-li:leading-relaxed prose-li:mb-1
                            prose-ul:my-4 prose-ul:list-disc prose-ul:pl-5
                            prose-ol:my-4 prose-ol:list-decimal prose-ol:pl-5"
                            v-html="parsedContent">
                        </div>
                    </div>

                    <!-- Back link -->
                    <Link href="/services"
                        class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-green-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Tous les services
                    </Link>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-4">

                        <!-- Price card -->
                        <div class="bg-gray-950 border border-gray-800 rounded-2xl p-6">
                            <div v-if="service.price && service.price > 0" class="mb-5">
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">À partir de</p>
                                <div class="text-4xl font-black text-white">
                                    {{ Number(service.price).toFixed(0) }}<span class="text-green-400 text-2xl"> €</span>
                                </div>
                            </div>
                            <div v-else class="mb-5">
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Tarif</p>
                                <div class="text-2xl font-black text-green-400">Sur devis</div>
                            </div>

                            <span v-if="service.is_premium"
                                class="inline-flex items-center gap-1.5 text-xs bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full mb-5">
                                ⭐ Contenu Premium
                            </span>

                            <a href="mailto:contact@multivoix.fr"
                                class="flex items-center justify-center gap-2 w-full py-4 bg-green-500 hover:bg-green-400 text-black font-bold rounded-xl transition-all duration-200 hover:scale-[1.02] mb-3 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Demander un devis
                            </a>
                        </div>

                        <!-- Guarantees -->
                        <div class="bg-gray-950 border border-gray-800 rounded-2xl p-5 space-y-3">
                            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-4">Inclus</p>
                            <div v-for="item in ['Réponse sous 24h', 'Devis personnalisé', 'Première consultation offerte', 'Suivi du projet']"
                                :key="item"
                                class="flex items-center gap-3 text-sm text-gray-400">
                                <div class="w-5 h-5 bg-green-500/15 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-3 h-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                {{ item }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
