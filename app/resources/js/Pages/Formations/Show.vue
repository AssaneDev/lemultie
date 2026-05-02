<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    formation: Object,
});

const levelLabels = { debutant: 'Débutant', intermediaire: 'Intermédiaire', avance: 'Avancé' };
const levelColors = {
    debutant: 'text-green-400 border-green-400/30 bg-green-400/10',
    intermediaire: 'text-yellow-400 border-yellow-400/30 bg-yellow-400/10',
    avance: 'text-red-400 border-red-400/30 bg-red-400/10',
};

const modules = computed(() => {
    if (!props.formation.modules) return [];
    return typeof props.formation.modules === 'string'
        ? JSON.parse(props.formation.modules)
        : props.formation.modules;
});

function purchase() {
    router.post(`/formations/${props.formation.slug}/order`);
}
</script>

<template>
    <AppLayout>
        <div class="py-20 px-4">
            <div class="max-w-5xl mx-auto">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-8">
                    <Link href="/formations" class="hover:text-green-400 transition-colors">Formations</Link>
                    <span>/</span>
                    <span class="text-gray-300">{{ formation.title }}</span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <!-- Main content -->
                    <div class="lg:col-span-2">
                        <!-- Hero image -->
                        <div class="rounded-2xl overflow-hidden mb-8 aspect-video bg-gradient-to-br from-green-900/30 to-black">
                            <img v-if="formation.image" :src="formation.image" :alt="formation.title" class="w-full h-full object-cover">
                            <div v-else class="w-full h-full flex items-center justify-center text-8xl opacity-20">🎓</div>
                        </div>

                        <!-- Title & badges -->
                        <div class="flex flex-wrap items-center gap-3 mb-4">
                            <span :class="`text-xs font-semibold border px-3 py-1 rounded-full ${levelColors[formation.level]}`">
                                {{ levelLabels[formation.level] }}
                            </span>
                            <span v-if="formation.duration_hours" class="text-xs text-gray-400">⏱ {{ formation.duration_hours }}h de contenu</span>
                            <span v-if="formation.max_students" class="text-xs text-gray-400">👥 Max {{ formation.max_students }} élèves</span>
                        </div>

                        <h1 class="text-4xl font-bold text-white mb-4">{{ formation.title }}</h1>
                        <p class="text-gray-300 text-lg leading-relaxed mb-8">{{ formation.description }}</p>

                        <!-- Video intro -->
                        <div v-if="formation.video_intro" class="mb-8 rounded-2xl overflow-hidden">
                            <div class="aspect-video">
                                <iframe :src="formation.video_intro" class="w-full h-full" allowfullscreen></iframe>
                            </div>
                        </div>

                        <!-- Modules -->
                        <div v-if="modules.length" class="mb-8">
                            <h2 class="text-2xl font-bold text-white mb-6">Programme</h2>
                            <div class="space-y-3">
                                <div
                                    v-for="(module, i) in modules"
                                    :key="i"
                                    class="flex items-start gap-4 bg-gray-900/40 border border-green-900/20 rounded-xl p-4"
                                >
                                    <div class="w-8 h-8 bg-green-500/20 border border-green-500/30 rounded-full flex items-center justify-center text-green-400 text-sm font-bold flex-shrink-0">
                                        {{ i + 1 }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-white">{{ module.title || module }}</div>
                                        <div v-if="module.description" class="text-sm text-gray-500 mt-1">{{ module.description }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div v-if="formation.content" class="prose prose-invert prose-green max-w-none" v-html="formation.content"></div>
                    </div>

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-24 bg-gray-900/60 border border-green-900/30 rounded-2xl p-6">
                            <div class="text-4xl font-bold text-green-400 mb-2">{{ formation.price }} €</div>
                            <p class="text-gray-500 text-sm mb-6">Accès illimité à vie</p>

                            <button
                                @click="purchase"
                                class="block w-full text-center py-4 bg-green-500 hover:bg-green-400 text-black font-bold rounded-xl transition-all duration-300 hover:scale-105 mb-3"
                            >
                                S'inscrire maintenant
                            </button>

                            <div class="space-y-2 mt-6 text-sm text-gray-400">
                                <div class="flex items-center gap-2">
                                    <span class="text-green-400">✓</span> Accès immédiat
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-green-400">✓</span> Contenu téléchargeable
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-green-400">✓</span> Support inclus
                                </div>
                                <div v-if="formation.duration_hours" class="flex items-center gap-2">
                                    <span class="text-green-400">✓</span> {{ formation.duration_hours }}h de contenu
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
