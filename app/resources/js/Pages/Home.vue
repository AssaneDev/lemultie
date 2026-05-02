<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const waveActive = ref(false);

onMounted(() => {
    setTimeout(() => { waveActive.value = true; }, 500);
});

const services = [
    {
        icon: '✍️',
        title: 'Copywriting',
        description: 'Événements, discours de mariage, textes pour associations. Des mots qui touchent juste.',
        color: 'from-green-500/20 to-emerald-500/10',
    },
    {
        icon: '🎙️',
        title: 'Voix Off',
        description: 'Une voix chaude et professionnelle pour vos projets audiovisuels et créatifs.',
        color: 'from-teal-500/20 to-green-500/10',
    },
    {
        icon: '🥁',
        title: 'Percussions',
        description: 'Le rythme comme langage universel. Ateliers, performances et créations percussives.',
        color: 'from-emerald-500/20 to-teal-500/10',
    },
    {
        icon: '🧘',
        title: 'Méditations',
        description: 'Guidances audio et vidéo pour retrouver calme, énergie et clarté intérieure.',
        color: 'from-green-400/20 to-emerald-400/10',
    },
    {
        icon: '📖',
        title: 'Contes',
        description: 'Le storytelling comme vecteur d\'émotion, de mémoire et de transformation.',
        color: 'from-teal-400/20 to-green-400/10',
    },
    {
        icon: '🎓',
        title: 'Formations',
        description: 'Oralité, rythmique, expression vocale — développez votre potentiel expressif.',
        color: 'from-emerald-400/20 to-teal-400/10',
    },
];
</script>

<template>
    <AppLayout>
        <!-- Hero Section -->
        <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
            <!-- Animated background -->
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-gradient-to-br from-black via-gray-950 to-black"></div>
                <!-- Sound wave animation -->
                <div class="absolute inset-0 flex items-center justify-center opacity-10">
                    <svg viewBox="0 0 800 200" class="w-full" preserveAspectRatio="xMidYMid slice">
                        <path
                            d="M0,100 Q50,50 100,100 Q150,150 200,100 Q250,50 300,100 Q350,150 400,100 Q450,50 500,100 Q550,150 600,100 Q650,50 700,100 Q750,150 800,100"
                            stroke="#22c55e" stroke-width="2" fill="none"
                            :class="{ 'wave-animate': waveActive }"
                        />
                        <path
                            d="M0,100 Q50,30 100,100 Q150,170 200,100 Q250,30 300,100 Q350,170 400,100 Q450,30 500,100 Q550,170 600,100 Q650,30 700,100 Q750,170 800,100"
                            stroke="#16a34a" stroke-width="1.5" fill="none" opacity="0.6"
                        />
                    </svg>
                </div>
                <!-- Radial glow -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-green-500/5 rounded-full blur-3xl"></div>
            </div>

            <div class="relative z-10 text-center px-4 max-w-4xl mx-auto">
                <!-- Microphone icon -->
                <div class="flex justify-center mb-8">
                    <div class="relative">
                        <div class="w-20 h-20 bg-green-500/10 border border-green-500/30 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                            </svg>
                        </div>
                        <div class="absolute -inset-2 bg-green-500/10 rounded-full blur-md animate-pulse"></div>
                    </div>
                </div>

                <!-- Headline -->
                <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6">
                    <span class="text-white">La voix qui</span>
                    <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-300">
                        transforme
                    </span>
                </h1>

                <p class="text-lg md:text-xl text-gray-400 leading-relaxed max-w-2xl mx-auto mb-10">
                    Copywriting, voix off, percussions, méditations et formations —
                    une plateforme immersive au service de votre expression.
                </p>

                <!-- CTA buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <Link
                        href="/services"
                        class="px-8 py-4 bg-green-500 hover:bg-green-400 text-black font-bold rounded-full text-lg transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-green-500/25"
                    >
                        Découvrir les services
                    </Link>
                    <Link
                        href="/meditations"
                        class="px-8 py-4 border border-green-500/40 hover:border-green-400 text-green-400 hover:text-green-300 font-semibold rounded-full text-lg transition-all duration-300"
                    >
                        Écouter une méditation
                    </Link>
                </div>
            </div>

            <!-- Scroll indicator -->
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
                <svg class="w-6 h-6 text-green-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </section>

        <!-- Services Section -->
        <section class="py-24 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <span class="text-green-400 text-sm font-semibold uppercase tracking-widest">Ce que je fais</span>
                    <h2 class="text-4xl md:text-5xl font-bold text-white mt-3">
                        Mes services
                    </h2>
                    <div class="w-16 h-1 bg-green-500 mx-auto mt-4 rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="service in services"
                        :key="service.title"
                        :class="`bg-gradient-to-br ${service.color} border border-green-900/30 rounded-2xl p-6 hover:border-green-500/40 transition-all duration-300 hover:-translate-y-1 group`"
                    >
                        <div class="text-4xl mb-4">{{ service.icon }}</div>
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-green-400 transition-colors">
                            {{ service.title }}
                        </h3>
                        <p class="text-gray-400 text-sm leading-relaxed">{{ service.description }}</p>
                    </div>
                </div>

                <div class="text-center mt-12">
                    <Link
                        href="/services"
                        class="inline-flex items-center text-green-400 hover:text-green-300 font-semibold transition-colors"
                    >
                        Voir tous les services
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </Link>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 px-4">
            <div class="max-w-3xl mx-auto text-center">
                <div class="bg-gradient-to-br from-green-900/20 to-emerald-900/10 border border-green-800/30 rounded-3xl p-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                        Prêt à donner vie à votre projet ?
                    </h2>
                    <p class="text-gray-400 mb-8 leading-relaxed">
                        Rejoignez la communauté Multi-Voix et accédez à du contenu exclusif,
                        des formations et des méditations guidées.
                    </p>
                    <Link
                        :href="route('register')"
                        class="px-10 py-4 bg-green-500 hover:bg-green-400 text-black font-bold rounded-full text-lg transition-all duration-300 hover:scale-105"
                    >
                        Commencer gratuitement
                    </Link>
                </div>
            </div>
        </section>
    </AppLayout>
</template>

<style scoped>
.wave-animate {
    animation: wave 4s ease-in-out infinite;
}

@keyframes wave {
    0%, 100% { d: path("M0,100 Q50,50 100,100 Q150,150 200,100 Q250,50 300,100 Q350,150 400,100 Q450,50 500,100 Q550,150 600,100 Q650,50 700,100 Q750,150 800,100"); }
    50% { d: path("M0,100 Q50,150 100,100 Q150,50 200,100 Q250,150 300,100 Q350,50 400,100 Q450,150 500,100 Q550,50 600,100 Q650,150 700,100 Q750,50 800,100"); }
}
</style>
