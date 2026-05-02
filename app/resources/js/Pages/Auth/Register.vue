<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Inscription — Multi-Voix" />

    <div class="min-h-screen bg-black flex items-center justify-center px-4">
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
                <p class="mt-3 text-gray-500 text-sm">Créez votre compte gratuitement</p>
            </div>

            <!-- Card -->
            <div class="bg-gray-900/60 border border-green-900/30 rounded-3xl p-8 backdrop-blur-sm">
                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Nom complet</label>
                        <input
                            v-model="form.name"
                            type="text"
                            required
                            autofocus
                            autocomplete="name"
                            class="w-full bg-gray-800/80 border border-gray-700 hover:border-gray-600 focus:border-green-500 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:outline-none transition-colors"
                            placeholder="Votre prénom et nom"
                        >
                        <p v-if="form.errors.name" class="mt-1.5 text-sm text-red-400">{{ form.errors.name }}</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Adresse email</label>
                        <input
                            v-model="form.email"
                            type="email"
                            required
                            autocomplete="username"
                            class="w-full bg-gray-800/80 border border-gray-700 hover:border-gray-600 focus:border-green-500 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:outline-none transition-colors"
                            placeholder="votre@email.fr"
                        >
                        <p v-if="form.errors.email" class="mt-1.5 text-sm text-red-400">{{ form.errors.email }}</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Mot de passe</label>
                        <input
                            v-model="form.password"
                            type="password"
                            required
                            autocomplete="new-password"
                            class="w-full bg-gray-800/80 border border-gray-700 hover:border-gray-600 focus:border-green-500 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:outline-none transition-colors"
                            placeholder="Minimum 8 caractères"
                        >
                        <p v-if="form.errors.password" class="mt-1.5 text-sm text-red-400">{{ form.errors.password }}</p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Confirmer le mot de passe</label>
                        <input
                            v-model="form.password_confirmation"
                            type="password"
                            required
                            autocomplete="new-password"
                            class="w-full bg-gray-800/80 border border-gray-700 hover:border-gray-600 focus:border-green-500 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:outline-none transition-colors"
                            placeholder="••••••••"
                        >
                        <p v-if="form.errors.password_confirmation" class="mt-1.5 text-sm text-red-400">{{ form.errors.password_confirmation }}</p>
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full py-3.5 bg-green-500 hover:bg-green-400 disabled:opacity-50 disabled:cursor-not-allowed text-black font-bold rounded-xl transition-all duration-300 hover:scale-[1.02] mt-2"
                    >
                        {{ form.processing ? 'Création...' : 'Créer mon compte' }}
                    </button>
                </form>

                <!-- Login link -->
                <p class="mt-6 text-center text-sm text-gray-500">
                    Déjà inscrit ?
                    <Link :href="route('login')" class="text-green-400 hover:text-green-300 font-medium transition-colors ml-1">
                        Se connecter
                    </Link>
                </p>
            </div>

            <div class="mt-6 text-center">
                <Link href="/" class="text-xs text-gray-600 hover:text-gray-400 transition-colors">
                    ← Retour à l'accueil
                </Link>
            </div>
        </div>
    </div>
</template>
