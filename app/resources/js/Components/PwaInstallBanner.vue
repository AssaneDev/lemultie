<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const show = ref(false);
const dismissed = ref(false);
let deferredPrompt = null;

function onBeforeInstall(e) {
    e.preventDefault();
    deferredPrompt = e;
    if (!localStorage.getItem('pwa-dismissed')) {
        setTimeout(() => { show.value = true; }, 3000);
    }
}

async function install() {
    if (!deferredPrompt) return;
    deferredPrompt.prompt();
    const { outcome } = await deferredPrompt.userChoice;
    deferredPrompt = null;
    show.value = false;
    if (outcome === 'accepted') localStorage.setItem('pwa-installed', '1');
}

function dismiss() {
    show.value = false;
    localStorage.setItem('pwa-dismissed', '1');
}

onMounted(() => window.addEventListener('beforeinstallprompt', onBeforeInstall));
onUnmounted(() => window.removeEventListener('beforeinstallprompt', onBeforeInstall));
</script>

<template>
    <transition
        enter-active-class="transition duration-500 ease-out"
        enter-from-class="opacity-0 translate-y-full"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition duration-300 ease-in"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 translate-y-full"
    >
        <div v-if="show"
            class="fixed bottom-4 left-4 right-4 z-[100] md:left-auto md:right-6 md:w-80">
            <div class="bg-gray-950 border border-green-500/30 rounded-2xl p-4 shadow-2xl shadow-black/50 backdrop-blur-xl">
                <div class="flex items-start gap-3">
                    <img src="/icons/icon-192.png" class="w-12 h-12 rounded-xl flex-shrink-0">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-white">Installer MultiVoix</p>
                        <p class="text-xs text-gray-400 mt-0.5 leading-relaxed">
                            Accédez aux méditations et formations hors ligne.
                        </p>
                    </div>
                    <button @click="dismiss" class="text-gray-600 hover:text-gray-400 flex-shrink-0 -mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="flex gap-2 mt-4">
                    <button @click="install"
                        class="flex-1 py-2.5 bg-green-500 hover:bg-green-400 text-black text-sm font-bold rounded-xl transition-colors">
                        Installer
                    </button>
                    <button @click="dismiss"
                        class="px-4 py-2.5 border border-gray-700 hover:border-gray-600 text-gray-400 text-sm rounded-xl transition-colors">
                        Plus tard
                    </button>
                </div>
            </div>
        </div>
    </transition>
</template>
