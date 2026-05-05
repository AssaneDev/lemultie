<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
    modelValue: { type: String, default: '' },
    fieldLabel: { type: String, default: 'description' },
    context: { type: String, default: '' },
    rows: { type: Number, default: 4 },
});

const emit = defineEmits(['update:modelValue']);

const open = ref(false);
const loading = ref(false);
const error = ref('');
const prompt = ref('');
const tone = ref('storytelling');

const tones = [
    { value: 'storytelling',   label: '✨ Storytelling immersif' },
    { value: 'pedagogique',    label: '📚 Pédagogique & clair' },
    { value: 'poetique',       label: '🌿 Poétique & contemplatif' },
    { value: 'professionnel',  label: '💼 Professionnel & convaincant' },
    { value: 'conversationnel',label: '💬 Conversationnel & proche' },
];

const contextHint = computed(() => props.context || prompt.value || '');

async function generate() {
    if (!contextHint.value.trim()) {
        error.value = 'Décris le sujet pour guider l\'IA.';
        return;
    }
    error.value = '';
    loading.value = true;
    try {
        const res = await axios.post('/admin/ai/generate', {
            context: contextHint.value,
            tone: tone.value,
            type: props.fieldLabel,
        });
        emit('update:modelValue', res.data.text);
        open.value = false;
        prompt.value = '';
    } catch (e) {
        error.value = e.response?.data?.error || 'Erreur lors de la génération.';
    } finally {
        loading.value = false;
    }
}
</script>

<template>
    <div class="space-y-2">
        <!-- Label row -->
        <div class="flex items-center justify-between">
            <slot name="label" />
            <button type="button" @click="open = !open"
                class="flex items-center gap-1.5 text-xs px-3 py-1 bg-purple-500/10 hover:bg-purple-500/20 border border-purple-500/30 hover:border-purple-400/50 text-purple-300 hover:text-purple-200 rounded-lg transition-all duration-200 font-medium">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Générer avec l'IA
            </button>
        </div>

        <!-- Textarea -->
        <textarea
            :value="modelValue"
            @input="emit('update:modelValue', $event.target.value)"
            :rows="rows"
            class="w-full bg-gray-800 border border-gray-600 rounded-xl px-4 py-3 text-white focus:border-green-500 focus:outline-none resize-none transition-colors"
        ></textarea>

        <!-- AI Panel -->
        <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0 -translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-1"
        >
            <div v-if="open" class="bg-gray-900 border border-purple-500/20 rounded-xl p-4 space-y-3">
                <!-- Tone selector -->
                <div>
                    <label class="text-xs text-gray-400 font-medium mb-2 block">Ton rédactionnel</label>
                    <div class="flex flex-wrap gap-2">
                        <button
                            v-for="t in tones"
                            :key="t.value"
                            type="button"
                            @click="tone = t.value"
                            :class="[
                                'text-xs px-3 py-1.5 rounded-lg border transition-all duration-150 font-medium',
                                tone === t.value
                                    ? 'bg-purple-500/20 border-purple-400/60 text-purple-200'
                                    : 'bg-gray-800 border-gray-700 text-gray-400 hover:border-gray-600 hover:text-gray-300'
                            ]"
                        >
                            {{ t.label }}
                        </button>
                    </div>
                </div>

                <!-- Context prompt -->
                <div>
                    <label class="text-xs text-gray-400 font-medium mb-2 block">
                        Contexte / sujet
                        <span v-if="context" class="text-gray-600 ml-1">(titre utilisé automatiquement si vide)</span>
                    </label>
                    <textarea
                        v-model="prompt"
                        rows="2"
                        :placeholder="context ? `Ex: ${context}` : 'Décris le sujet, l\'ambiance, le public cible...'"
                        class="w-full bg-gray-800 border border-gray-700 focus:border-purple-500 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-600 focus:outline-none resize-none"
                    ></textarea>
                </div>

                <!-- Error -->
                <p v-if="error" class="text-red-400 text-xs">{{ error }}</p>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        @click="generate"
                        :disabled="loading"
                        class="flex items-center gap-2 px-5 py-2 bg-purple-600 hover:bg-purple-500 disabled:opacity-50 disabled:cursor-not-allowed text-white text-sm font-semibold rounded-lg transition-all duration-200"
                    >
                        <svg v-if="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        {{ loading ? 'Génération...' : 'Générer' }}
                    </button>
                    <button type="button" @click="open = false; error = ''" class="text-sm text-gray-500 hover:text-gray-300 transition-colors">
                        Annuler
                    </button>
                    <span class="text-xs text-gray-600 ml-auto">Propulsé par Groq · Llama 3.3</span>
                </div>
            </div>
        </transition>
    </div>
</template>
