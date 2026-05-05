<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';

const props = defineProps({
    services: Array,
    meditations: Array,
    formations: Array,
    articles: Array,
});

const heroVisible = ref(false);
onMounted(() => setTimeout(() => { heroVisible.value = true; }, 100));

const themeLabels = {
    relaxation: 'Relaxation', sommeil: 'Sommeil', concentration: 'Concentration',
    energie: 'Énergie', guerison: 'Guérison', autre: 'Autre',
};

const levelLabels = { debutant: 'Débutant', intermediaire: 'Intermédiaire', avance: 'Avancé' };

function formatDuration(s) {
    if (!s) return '';
    const m = Math.floor(s / 60);
    return `${m} min`;
}


const categoryIcons = {
    copywriting: '✍️',
    voix_off:    '🎙️',
    percussion:  '🥁',
    meditation:  '🧘',
    conte:       '📖',
    formation:   '🎓',
    conference:  '🎤',
};

const stats = [
    { value: '500+', label: 'Élèves formés' },
    { value: '12', label: 'Années d\'expérience' },
    { value: '3', label: 'Disciplines maîtrisées' },
    { value: '98%', label: 'Satisfaction' },
];
</script>

<template>
    <AppLayout>

        <!-- ─── HERO ─────────────────────────────────────────────────────── -->
        <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
            <!-- Background layers -->
            <div class="absolute inset-0 bg-gradient-to-br from-black via-gray-950 to-black"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_50%_at_50%_-20%,rgba(34,197,94,0.08),transparent)]"></div>

            <!-- Animated rings -->
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-[600px] h-[600px] border border-green-500/5 rounded-full animate-[spin_30s_linear_infinite]"></div>
                <div class="absolute w-[400px] h-[400px] border border-green-500/8 rounded-full animate-[spin_20s_linear_infinite_reverse]"></div>
                <div class="absolute w-[250px] h-[250px] border border-green-500/10 rounded-full animate-[spin_12s_linear_infinite]"></div>
            </div>

            <div class="relative z-10 text-center px-4 max-w-5xl mx-auto"
                :class="heroVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
                style="transition: opacity 0.8s ease, transform 0.8s ease">

                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-green-500/10 border border-green-500/20 rounded-full text-green-400 text-xs font-semibold uppercase tracking-widest mb-8">
                    <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
                    Plateforme MultiVoix
                </div>

                <!-- Headline -->
                <h1 class="text-5xl md:text-7xl lg:text-8xl font-black leading-[1.05] mb-6 tracking-tight">
                    <span class="text-white">La voix qui</span>
                    <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 via-emerald-300 to-green-500">
                        transforme
                    </span>
                </h1>

                <p class="text-lg md:text-xl text-gray-400 leading-relaxed max-w-2xl mx-auto mb-12">
                    Copywriting, voix off, percussions, méditations et formations —
                    une plateforme immersive au service de votre expression.
                </p>

                <!-- CTAs -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="#services"
                        @click.prevent="document.getElementById('services')?.scrollIntoView({behavior:'smooth'})"
                        class="px-8 py-4 bg-green-500 hover:bg-green-400 text-black font-bold rounded-full text-base transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-green-500/20 cursor-pointer">
                        Découvrir les services
                    </a>
                    <a href="#meditations"
                        @click.prevent="document.getElementById('meditations')?.scrollIntoView({behavior:'smooth'})"
                        class="px-8 py-4 border border-green-500/30 hover:border-green-400 text-green-400 hover:text-green-300 font-semibold rounded-full text-base transition-all duration-300 hover:bg-green-500/5 cursor-pointer">
                        Écouter une méditation
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-20 max-w-2xl mx-auto">
                    <div v-for="stat in stats" :key="stat.label" class="text-center">
                        <div class="text-2xl md:text-3xl font-black text-green-400">{{ stat.value }}</div>
                        <div class="text-xs text-gray-500 mt-1">{{ stat.label }}</div>
                    </div>
                </div>
            </div>

            <!-- Scroll indicator -->
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce opacity-40">
                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </section>

        <!-- ─── SERVICES ──────────────────────────────────────────────────── -->
        <section id="services" class="py-28 px-4 relative">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_60%_40%_at_50%_50%,rgba(34,197,94,0.03),transparent)]"></div>
            <div class="max-w-7xl mx-auto relative">

                <div class="text-center mb-16">
                    <span class="text-green-400 text-xs font-semibold uppercase tracking-widest">Ce que je propose</span>
                    <h2 class="text-4xl md:text-5xl font-black text-white mt-3 tracking-tight">Mes services</h2>
                    <div class="w-12 h-0.5 bg-green-500 mx-auto mt-5 rounded-full"></div>
                </div>

                <!-- Services dynamiques -->
                <div v-if="services?.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <Link v-for="s in services" :key="s.id" :href="`/services/${s.slug}`"
                        class="group relative bg-gray-950/80 border border-gray-800 hover:border-green-500/40 rounded-2xl p-7 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-green-500/5 block">
                        <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-green-500/0 to-green-500/0 group-hover:from-green-500/5 group-hover:to-transparent transition-all duration-300"></div>
                        <div class="relative">
                            <div class="text-4xl mb-5">{{ categoryIcons[s.category] ?? '✨' }}</div>
                            <h3 class="text-lg font-bold text-white mb-3 group-hover:text-green-400 transition-colors">{{ s.title }}</h3>
                            <p class="text-sm text-gray-500 leading-relaxed line-clamp-3">{{ s.description }}</p>
                            <div class="mt-5 flex items-center text-xs text-green-500 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                                En savoir plus <svg class="ml-1.5 w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </div>
                        </div>
                    </Link>
                </div>

                <!-- Empty state -->
                <div v-else class="text-center py-20">
                    <div class="text-5xl mb-4 opacity-20">✨</div>
                    <p class="text-gray-600">Aucun service disponible pour l'instant.</p>
                </div>
            </div>
        </section>

        <!-- ─── MÉDITATIONS ───────────────────────────────────────────────── -->
        <section id="meditations" class="py-28 px-4 bg-gray-950/50">
            <div class="max-w-7xl mx-auto">

                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-16">
                    <div>
                        <span class="text-green-400 text-xs font-semibold uppercase tracking-widest">Guidances audio & vidéo</span>
                        <h2 class="text-4xl md:text-5xl font-black text-white mt-3 tracking-tight">Méditations</h2>
                        <div class="w-12 h-0.5 bg-green-500 mt-5 rounded-full"></div>
                    </div>
                    <Link href="/meditations" class="text-sm text-green-400 hover:text-green-300 font-semibold flex items-center gap-1.5 transition-colors shrink-0">
                        Toutes les méditations <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </Link>
                </div>

                <!-- Grid méditations -->
                <div v-if="meditations?.length" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <Link v-for="m in meditations" :key="m.id" :href="`/meditations/${m.slug}`"
                        class="group bg-gray-950 border border-gray-800 hover:border-green-500/40 rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-green-500/5 block">
                        <!-- Visual -->
                        <div class="aspect-video bg-gradient-to-br from-green-900/20 via-black to-gray-900 flex items-center justify-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(34,197,94,0.08),transparent_70%)]"></div>
                            <div class="text-center relative z-10">
                                <div class="text-5xl mb-2 opacity-60">{{ m.type === 'video' ? '▶' : '🎧' }}</div>
                            </div>
                            <!-- Type badge -->
                            <div class="absolute top-3 right-3">
                                <span class="text-xs px-2 py-0.5 bg-black/60 border border-green-500/30 text-green-400 rounded-full font-medium backdrop-blur-sm">
                                    {{ m.type === 'video' ? 'Vidéo' : m.type === 'both' ? 'Audio + Vidéo' : 'Audio' }}
                                </span>
                            </div>
                            <div v-if="m.is_premium" class="absolute top-3 left-3">
                                <span class="text-xs px-2 py-0.5 bg-yellow-500/20 border border-yellow-500/30 text-yellow-400 rounded-full font-medium">⭐ Premium</span>
                            </div>
                        </div>
                        <!-- Content -->
                        <div class="p-5">
                            <span class="text-xs text-green-500 font-semibold uppercase tracking-wider">{{ themeLabels[m.theme] }}</span>
                            <h3 class="text-base font-bold text-white mt-1.5 mb-2 group-hover:text-green-400 transition-colors line-clamp-2">{{ m.title }}</h3>
                            <div class="flex items-center gap-3 text-xs text-gray-600">
                                <span v-if="m.duration_seconds">⏱ {{ formatDuration(m.duration_seconds) }}</span>
                            </div>
                        </div>
                    </Link>
                </div>

                <!-- Empty state -->
                <div v-else class="text-center py-20">
                    <div class="text-5xl mb-4 opacity-20">🧘</div>
                    <p class="text-gray-600">Aucune méditation disponible pour l'instant.</p>
                </div>

                <div class="text-center mt-12">
                    <Link href="/meditations"
                        class="inline-flex items-center gap-2 px-7 py-3 border border-green-500/30 hover:border-green-400 text-green-400 hover:text-green-300 font-semibold rounded-full text-sm transition-all duration-300 hover:bg-green-500/5">
                        Voir toutes les méditations
                    </Link>
                </div>
            </div>
        </section>

        <!-- ─── FORMATIONS ────────────────────────────────────────────────── -->
        <section id="formations" class="py-28 px-4">
            <div class="max-w-7xl mx-auto">

                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-16">
                    <div>
                        <span class="text-green-400 text-xs font-semibold uppercase tracking-widest">Apprenez à votre rythme</span>
                        <h2 class="text-4xl md:text-5xl font-black text-white mt-3 tracking-tight">Formations</h2>
                        <div class="w-12 h-0.5 bg-green-500 mt-5 rounded-full"></div>
                    </div>
                    <Link href="/formations" class="text-sm text-green-400 hover:text-green-300 font-semibold flex items-center gap-1.5 transition-colors shrink-0">
                        Toutes les formations <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </Link>
                </div>

                <div v-if="formations?.length" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <Link v-for="f in formations" :key="f.id" :href="`/formations/${f.slug}`"
                        class="group bg-gray-950 border border-gray-800 hover:border-green-500/40 rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-green-500/5 flex flex-col block">
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div class="w-10 h-10 bg-green-500/10 border border-green-500/20 rounded-xl flex items-center justify-center text-xl flex-shrink-0">🎓</div>
                            <span v-if="f.is_premium" class="text-xs px-2 py-0.5 bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 rounded-full">Premium</span>
                            <span v-else class="text-xs px-2 py-0.5 bg-green-500/10 border border-green-500/20 text-green-400 rounded-full">Gratuit</span>
                        </div>
                        <h3 class="text-base font-bold text-white mb-2 group-hover:text-green-400 transition-colors line-clamp-2 flex-1">{{ f.title }}</h3>
                        <p v-if="f.description" class="text-sm text-gray-500 leading-relaxed mb-4 line-clamp-2">{{ f.description }}</p>
                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-800/50">
                            <div class="flex items-center gap-3 text-xs text-gray-600">
                                <span v-if="f.level">{{ levelLabels[f.level] || f.level }}</span>
                                <span v-if="f.duration_hours">· {{ f.duration_hours }}h</span>
                            </div>
                            <span v-if="f.price > 0" class="text-green-400 font-bold text-sm">{{ Number(f.price).toFixed(0) }} €</span>
                            <span v-else class="text-green-400 font-semibold text-sm">Gratuit</span>
                        </div>
                    </Link>
                </div>

                <div v-else class="text-center py-20">
                    <div class="text-5xl mb-4 opacity-20">🎓</div>
                    <p class="text-gray-600">Aucune formation disponible pour l'instant.</p>
                </div>

                <div class="text-center mt-12">
                    <Link href="/formations"
                        class="inline-flex items-center gap-2 px-7 py-3 border border-green-500/30 hover:border-green-400 text-green-400 hover:text-green-300 font-semibold rounded-full text-sm transition-all duration-300 hover:bg-green-500/5">
                        Voir toutes les formations
                    </Link>
                </div>
            </div>
        </section>

        <!-- ─── À PROPOS ──────────────────────────────────────────────────── -->
        <section id="a-propos" class="py-28 px-4 bg-gray-950/50">
            <div class="max-w-5xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">

                    <!-- Visual -->
                    <div class="relative flex justify-center">
                        <div class="relative w-72 h-72">
                            <div class="absolute inset-0 bg-gradient-to-br from-green-500/20 to-emerald-500/5 rounded-full blur-2xl"></div>
                            <div class="relative w-full h-full bg-gray-900 border border-green-500/20 rounded-full flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-8xl mb-2">🎙️</div>
                                    <div class="w-16 h-0.5 bg-green-500/40 mx-auto rounded-full"></div>
                                </div>
                            </div>
                            <!-- Floating badges -->
                            <div class="absolute -top-2 -right-4 bg-green-500/10 border border-green-500/20 rounded-xl px-3 py-1.5 text-xs text-green-400 font-semibold backdrop-blur-sm">
                                🥁 Percussions
                            </div>
                            <div class="absolute -bottom-2 -left-4 bg-green-500/10 border border-green-500/20 rounded-xl px-3 py-1.5 text-xs text-green-400 font-semibold backdrop-blur-sm">
                                ✍️ Copywriting
                            </div>
                        </div>
                    </div>

                    <!-- Text -->
                    <div>
                        <span class="text-green-400 text-xs font-semibold uppercase tracking-widest">À propos</span>
                        <h2 class="text-3xl md:text-4xl font-black text-white mt-3 mb-6 tracking-tight leading-tight">
                            L'art de l'expression<br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-300">sous toutes ses formes</span>
                        </h2>
                        <div class="space-y-4 text-gray-400 leading-relaxed text-sm">
                            <p>
                                Multi-Voix est une plateforme dédiée à l'expression humaine dans toute sa richesse —
                                la voix, le rythme, le mot et le silence.
                            </p>
                            <p>
                                Copywriter, voix off, percussionniste, conteur et accompagnateur en méditation,
                                je mets mes disciplines au service de votre transformation et de vos projets.
                            </p>
                            <p>
                                Que vous cherchiez à développer votre expression, trouver la paix intérieure
                                ou donner vie à un projet créatif, Multi-Voix est votre espace.
                            </p>
                        </div>
                        <div class="mt-8 flex flex-wrap gap-3">
                            <span v-for="tag in ['Voix', 'Rythme', 'Émotion', 'Transformation', 'Expression']" :key="tag"
                                class="px-3 py-1 bg-green-500/10 border border-green-500/20 text-green-400 text-xs rounded-full font-medium">
                                {{ tag }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ─── BLOG ──────────────────────────────────────────────────────── -->
        <section v-if="articles?.length" id="blog" class="py-28 px-4">
            <div class="max-w-7xl mx-auto">

                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-16">
                    <div>
                        <span class="text-green-400 text-xs font-semibold uppercase tracking-widest">Actualités & réflexions</span>
                        <h2 class="text-4xl md:text-5xl font-black text-white mt-3 tracking-tight">Blog</h2>
                        <div class="w-12 h-0.5 bg-green-500 mt-5 rounded-full"></div>
                    </div>
                    <Link href="/blog" class="text-sm text-green-400 hover:text-green-300 font-semibold flex items-center gap-1.5 transition-colors shrink-0">
                        Tous les articles <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </Link>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <Link v-for="a in articles" :key="a.id" :href="`/blog/${a.slug}`"
                        class="group bg-gray-950 border border-gray-800 hover:border-green-500/40 rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 block">
                        <span v-if="a.type" class="text-xs text-green-500 font-semibold uppercase tracking-wider">{{ a.type === 'conference' ? 'Conférence' : 'Article' }}</span>
                        <h3 class="text-base font-bold text-white mt-2 mb-3 group-hover:text-green-400 transition-colors line-clamp-2">{{ a.title }}</h3>
                        <p v-if="a.excerpt" class="text-sm text-gray-500 line-clamp-3 leading-relaxed">{{ a.excerpt }}</p>
                        <div class="mt-4 flex items-center text-xs text-green-500 font-semibold opacity-0 group-hover:opacity-100 transition-opacity">
                            Lire l'article <svg class="ml-1.5 w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </Link>
                </div>
            </div>
        </section>

        <!-- ─── CTA / CONTACT ─────────────────────────────────────────────── -->
        <section id="contact" class="py-28 px-4 bg-gray-950/50">
            <div class="max-w-4xl mx-auto">
                <div class="relative bg-gradient-to-br from-green-950/40 to-gray-950 border border-green-900/30 rounded-3xl p-12 md:p-16 overflow-hidden text-center">
                    <!-- Glow -->
                    <div class="absolute inset-0 bg-[radial-gradient(ellipse_60%_60%_at_50%_0%,rgba(34,197,94,0.08),transparent)]"></div>
                    <div class="relative z-10">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-green-500/10 border border-green-500/20 rounded-full text-green-400 text-xs font-semibold uppercase tracking-widest mb-8">
                            <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
                            Rejoignez la communauté
                        </div>
                        <h2 class="text-3xl md:text-5xl font-black text-white mb-5 tracking-tight leading-tight">
                            Prêt à donner vie<br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-300">à votre projet ?</span>
                        </h2>
                        <p class="text-gray-400 mb-10 leading-relaxed max-w-xl mx-auto">
                            Accédez à du contenu exclusif, des formations et des méditations guidées.
                            Commencez gratuitement, sans carte bancaire.
                        </p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                            <Link :href="route('register')"
                                class="px-10 py-4 bg-green-500 hover:bg-green-400 text-black font-bold rounded-full text-base transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-green-500/20">
                                Commencer gratuitement
                            </Link>
                            <Link :href="route('login')"
                                class="px-10 py-4 border border-green-500/30 hover:border-green-400 text-green-400 hover:text-green-300 font-semibold rounded-full text-base transition-all duration-300 hover:bg-green-500/5">
                                Se connecter
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </AppLayout>
</template>
