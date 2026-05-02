<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({ articles: Array });

function formatDate(d) {
    return d ? new Date(d).toLocaleDateString('fr-FR') : '—';
}

function destroy(id) {
    if (confirm('Supprimer cet article ?')) router.delete(`/admin/articles/${id}`);
}
</script>

<template>
    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-200">Gestion des Articles</h2>
                <Link href="/admin/articles/create" class="px-4 py-2 bg-green-500 hover:bg-green-400 text-black font-semibold rounded-lg text-sm">
                    + Nouvel article
                </Link>
            </div>
        </template>
        <div class="py-8 px-4 max-w-6xl mx-auto">
            <div class="bg-gray-900/50 border border-gray-700/30 rounded-2xl overflow-hidden">
                <table class="w-full">
                    <thead class="border-b border-gray-700/30">
                        <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <th class="px-6 py-4">Titre</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Auteur</th>
                            <th class="px-6 py-4">Publié le</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        <tr v-for="a in articles" :key="a.id" class="hover:bg-gray-800/30">
                            <td class="px-6 py-4 font-medium text-white max-w-xs truncate">{{ a.title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-400 capitalize">{{ a.type }}</td>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ a.author?.name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ formatDate(a.published_at) }}</td>
                            <td class="px-6 py-4">
                                <span :class="`text-xs px-2 py-1 rounded-full ${a.is_published ? 'bg-green-500/20 text-green-400' : 'bg-gray-700 text-gray-400'}`">
                                    {{ a.is_published ? 'Publié' : 'Brouillon' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex gap-3">
                                <Link :href="`/admin/articles/${a.id}/edit`" class="text-sm text-blue-400 hover:text-blue-300">Éditer</Link>
                                <button @click="destroy(a.id)" class="text-sm text-red-400 hover:text-red-300">Supprimer</button>
                            </td>
                        </tr>
                        <tr v-if="!articles?.length">
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">Aucun article.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
