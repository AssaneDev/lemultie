<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';

function parseText(text) {
    if (!text) return '';
    // Si c'est déjà du HTML, on le retourne tel quel
    if (text.trim().startsWith('<')) return text;

    const lines = text.replace(/\\n/g, '\n').split('\n');
    let html = '';
    let inUl = false, inOl = false;

    function closeList() {
        if (inUl) { html += '</ul>'; inUl = false; }
        if (inOl) { html += '</ol>'; inOl = false; }
    }

    function inline(str) {
        return str
            .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.+?)\*/g, '<em>$1</em>');
    }

    let i = 0;
    while (i < lines.length) {
        const line = lines[i].trim();

        if (!line) {
            closeList();
            i++;
            continue;
        }

        const olMatch = line.match(/^(\d+)\.\s+(.+)/);
        const ulMatch = line.match(/^[-*]\s+(.+)/);
        const h2Match = line.match(/^##\s+(.+)/);
        const h3Match = line.match(/^###\s+(.+)/);

        if (h2Match) {
            closeList();
            html += `<h2>${inline(h2Match[1])}</h2>`;
        } else if (h3Match) {
            closeList();
            html += `<h3>${inline(h3Match[1])}</h3>`;
        } else if (ulMatch) {
            if (!inUl) { closeList(); html += '<ul>'; inUl = true; }
            html += `<li>${inline(ulMatch[1])}</li>`;
        } else if (olMatch) {
            if (!inOl) { closeList(); html += '<ol>'; inOl = true; }
            html += `<li>${inline(olMatch[2])}</li>`;
        } else {
            closeList();
            html += `<p>${inline(line)}</p>`;
        }
        i++;
    }
    closeList();
    return html;
}

const props = defineProps({ formation: Object });

const levelLabels = { debutant: 'Débutant', intermediaire: 'Intermédiaire', avance: 'Avancé' };
const levelColors = {
    debutant:      'text-green-400 border-green-400/30 bg-green-400/10',
    intermediaire: 'text-yellow-400 border-yellow-400/30 bg-yellow-400/10',
    avance:        'text-red-400 border-red-400/30 bg-red-400/10',
};

const modules = computed(() => {
    if (!props.formation.modules) return [];
    return typeof props.formation.modules === 'string'
        ? JSON.parse(props.formation.modules)
        : props.formation.modules;
});

const isFree = computed(() => !props.formation.price || Number(props.formation.price) === 0)
const parsedDescription = computed(() => parseText(props.formation.description))
const parsedContent = computed(() => parseText(props.formation.content));

function purchase() {
    router.post(`/formations/${props.formation.slug}/order`);
}
</script>

<template>
    <AppLayout>

        <!-- Hero -->
        <div class="relative min-h-[60vh] flex items-end overflow-hidden">
            <div class="absolute inset-0">
                <!-- Base -->
                <div class="absolute inset-0 bg-[#030712]"></div>

                <!-- Photo de fond si disponible -->
                <img v-if="formation.image" :src="formation.image" :alt="formation.title"
                    class="absolute inset-0 w-full h-full object-cover opacity-10">

                <!-- Grille de points -->
                <div class="absolute inset-0 opacity-[0.03]"
                    style="background-image: radial-gradient(circle, #22c55e 1px, transparent 1px); background-size: 32px 32px;"></div>

                <!-- Glow principal vert -->
                <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-green-500/10 rounded-full blur-[100px]"></div>

                <!-- Glow secondaire décalé -->
                <div class="absolute top-20 -left-20 w-[400px] h-[400px] bg-emerald-600/8 rounded-full blur-[80px]"></div>
                <div class="absolute top-10 -right-10 w-[300px] h-[300px] bg-green-400/6 rounded-full blur-[60px]"></div>

                <!-- Ligne horizontale lumineuse -->
                <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-green-500/30 to-transparent"></div>

                <!-- Cercles décoratifs -->
                <div class="absolute top-16 right-[15%] w-56 h-56 border border-green-500/8 rounded-full"></div>
                <div class="absolute top-24 right-[15%] w-40 h-40 border border-green-500/6 rounded-full translate-x-8 translate-y-8"></div>

                <!-- SVG noise / texture subtile -->
                <div class="absolute inset-0 opacity-[0.015] mix-blend-overlay"
                    style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 256 256%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noise%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.9%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noise)%22 opacity=%221%22/%3E%3C/svg%3E'); background-size: 200px;"></div>

                <!-- Dégradé bas pour transition vers le contenu -->
                <div class="absolute bottom-0 left-0 right-0 h-40 bg-gradient-to-t from-black to-transparent"></div>
            </div>

            <div class="relative z-10 w-full max-w-5xl mx-auto px-4 pb-14 pt-32">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-xs text-gray-600 mb-6">
                    <Link href="/formations" class="hover:text-green-400 transition-colors">Formations</Link>
                    <span>/</span>
                    <span class="text-gray-400">{{ formation.title }}</span>
                </div>

                <!-- Badges -->
                <div class="flex flex-wrap items-center gap-2 mb-5">
                    <span :class="`text-xs font-semibold border px-3 py-1 rounded-full ${levelColors[formation.level]}`">
                        {{ levelLabels[formation.level] }}
                    </span>
                    <span v-if="formation.is_premium"
                        class="text-xs px-3 py-1 rounded-full bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 font-semibold">
                        ⭐ Premium
                    </span>
                </div>

                <!-- Title -->
                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight leading-tight mb-5 max-w-3xl">
                    {{ formation.title }}
                </h1>

                <!-- Stats row -->
                <div class="flex flex-wrap items-center gap-6 text-sm text-gray-500">
                    <div v-if="formation.duration_hours" class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ formation.duration_hours }}h de contenu
                    </div>
                    <div v-if="formation.max_students" class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ formation.max_students }} places max
                    </div>
                    <div v-if="modules.length" class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        {{ modules.length }} modules
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-5xl mx-auto px-4 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                <!-- Main -->
                <div class="lg:col-span-2 space-y-10">

                    <!-- Description -->
                    <div class="prose prose-invert prose-green max-w-none
                        prose-p:text-gray-300 prose-p:leading-loose prose-p:text-base
                        prose-strong:text-white prose-strong:font-bold
                        prose-li:text-gray-300 prose-li:leading-relaxed
                        prose-ul:space-y-1 prose-ol:space-y-1"
                        v-html="parsedDescription">
                    </div>

                    <!-- Video intro -->
                    <div v-if="formation.video_intro" class="rounded-2xl overflow-hidden border border-gray-800">
                        <div class="aspect-video">
                            <iframe :src="formation.video_intro" class="w-full h-full" allowfullscreen></iframe>
                        </div>
                    </div>

                    <!-- Modules / Programme -->
                    <div v-if="modules.length">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-8 h-8 bg-green-500/10 border border-green-500/20 rounded-lg flex items-center justify-center text-green-400 text-sm">📋</div>
                            <h2 class="text-2xl font-black text-white">Programme</h2>
                        </div>
                        <div class="space-y-3">
                            <div v-for="(module, i) in modules" :key="i"
                                class="group flex items-start gap-4 bg-gray-950 border border-gray-800 hover:border-green-500/30 rounded-xl p-5 transition-all duration-200">
                                <div class="w-8 h-8 bg-green-500/10 border border-green-500/20 group-hover:bg-green-500/20 rounded-full flex items-center justify-center text-green-400 text-xs font-black flex-shrink-0 transition-colors">
                                    {{ i + 1 }}
                                </div>
                                <div>
                                    <div class="font-semibold text-white text-sm">{{ module.title || module }}</div>
                                    <div v-if="module.description" class="text-xs text-gray-500 mt-1 leading-relaxed">{{ module.description }}</div>
                                </div>
                                <svg class="w-4 h-4 text-gray-700 group-hover:text-green-500 ml-auto flex-shrink-0 mt-0.5 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Long content -->
                    <div v-if="formation.content"
                        class="bg-gray-950/60 border border-gray-800/60 rounded-2xl p-8">
                        <div class="prose prose-invert prose-green max-w-none
                            prose-h2:text-2xl prose-h2:font-black prose-h2:text-white prose-h2:mt-8 prose-h2:mb-4
                            prose-h3:text-lg prose-h3:font-bold prose-h3:text-green-400 prose-h3:mt-6 prose-h3:mb-3
                            prose-p:text-gray-300 prose-p:leading-loose prose-p:text-base prose-p:mb-4
                            prose-strong:text-white prose-strong:font-bold
                            prose-li:text-gray-300 prose-li:leading-relaxed prose-li:mb-1
                            prose-ul:my-4 prose-ul:space-y-1
                            prose-ol:my-4 prose-ol:space-y-1
                            prose-ul:list-disc prose-ul:pl-5
                            prose-ol:list-decimal prose-ol:pl-5"
                            v-html="parsedContent">
                        </div>
                    </div>

                    <!-- Back -->
                    <Link href="/formations"
                        class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-green-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Toutes les formations
                    </Link>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-4">

                        <!-- Price + CTA -->
                        <div class="bg-gray-950 border border-gray-800 rounded-2xl p-6">
                            <!-- Price -->
                            <div class="mb-6">
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Tarif</p>
                                <div v-if="isFree" class="text-3xl font-black text-green-400">Gratuit</div>
                                <div v-else class="flex items-baseline gap-1">
                                    <span class="text-4xl font-black text-white">{{ Number(formation.price).toFixed(0) }}</span>
                                    <span class="text-green-400 text-xl font-bold">€</span>
                                </div>
                                <p class="text-xs text-gray-600 mt-1">Accès illimité à vie</p>
                            </div>

                            <!-- CTA -->
                            <button @click="purchase"
                                class="flex items-center justify-center gap-2 w-full py-4 bg-green-500 hover:bg-green-400 text-black font-bold rounded-xl transition-all duration-200 hover:scale-[1.02] text-sm mb-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                {{ isFree ? 'Accéder gratuitement' : 'S\'inscrire maintenant' }}
                            </button>
                        </div>

                        <!-- What's included -->
                        <div class="bg-gray-950 border border-gray-800 rounded-2xl p-5">
                            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-4">Ce qui est inclus</p>
                            <div class="space-y-3">
                                <div v-for="item in [
                                    'Accès immédiat',
                                    'Contenu téléchargeable',
                                    'Support inclus',
                                    ...(formation.duration_hours ? [formation.duration_hours + 'h de contenu vidéo'] : []),
                                    ...(modules.length ? [modules.length + ' modules structurés'] : []),
                                ]" :key="item" class="flex items-center gap-3 text-sm text-gray-400">
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
        </div>
    </AppLayout>
</template>
