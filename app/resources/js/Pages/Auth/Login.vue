<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Connexion — Multi-Voix" />

    <div class="min-h-screen bg-black flex items-center justify-center px-4">
        <!-- Background glow -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-green-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-10">
                <Link href="/" class="inline-flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-500/10 border border-green-500/30 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                        </svg>
                    </div>
                    <span class="font-bold text-2xl text-white">Multi<span class="text-green-400">Voix</span></span>
                </Link>
                <p class="mt-3 text-gray-500 text-sm">Connectez-vous à votre espace</p>
            </div>

            <!-- Card -->
            <div class="bg-gray-900/60 border border-green-900/30 rounded-3xl p-8 backdrop-blur-sm">
                <!-- Status message -->
                <div v-if="status" class="mb-6 text-sm text-green-400 bg-green-500/10 border border-green-500/20 rounded-xl px-4 py-3">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Adresse email</label>
                        <input
                            v-model="form.email"
                            type="email"
                            required
                            autofocus
                            autocomplete="username"
                            class="w-full bg-gray-800/80 border border-gray-700 hover:border-gray-600 focus:border-green-500 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:outline-none transition-colors"
                            placeholder="votre@email.fr"
                        >
                        <p v-if="form.errors.email" class="mt-1.5 text-sm text-red-400">{{ form.errors.email }}</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-sm font-medium text-gray-300">Mot de passe</label>
                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="text-xs text-green-400 hover:text-green-300 transition-colors"
                            >
                                Mot de passe oublié ?
                            </Link>
                        </div>
                        <input
                            v-model="form.password"
                            type="password"
                            required
                            autocomplete="current-password"
                            class="w-full bg-gray-800/80 border border-gray-700 hover:border-gray-600 focus:border-green-500 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:outline-none transition-colors"
                            placeholder="••••••••"
                        >
                        <p v-if="form.errors.password" class="mt-1.5 text-sm text-red-400">{{ form.errors.password }}</p>
                    </div>

                    <!-- Remember me -->
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" v-model="form.remember" class="w-4 h-4 accent-green-500 rounded">
                        <span class="text-sm text-gray-400">Se souvenir de moi</span>
                    </label>

                    <!-- Submit -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full py-3.5 bg-green-500 hover:bg-green-400 disabled:opacity-50 disabled:cursor-not-allowed text-black font-bold rounded-xl transition-all duration-300 hover:scale-[1.02] mt-2"
                    >
                        {{ form.processing ? 'Connexion...' : 'Se connecter' }}
                    </button>
                </form>

                <!-- Register link -->
                <p class="mt-6 text-center text-sm text-gray-500">
                    Pas encore de compte ?
                    <Link :href="route('register')" class="text-green-400 hover:text-green-300 font-medium transition-colors ml-1">
                        S'inscrire gratuitement
                    </Link>
                </p>
            </div>

            <!-- Back to home -->
            <div class="mt-6 text-center">
                <Link href="/" class="text-xs text-gray-600 hover:text-gray-400 transition-colors">
                    ← Retour à l'accueil
                </Link>
            </div>
        </div>
    </div>
</template>
