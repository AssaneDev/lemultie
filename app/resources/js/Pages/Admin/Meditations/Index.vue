<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({ meditations: Array });

const themeLabels = {
    relaxation: 'Relaxation', sommeil: 'Sommeil', concentration: 'Concentration',
    energie: 'Énergie', guerison: 'Guérison', autre: 'Autre',
};

function destroy(id) {
    if (confirm('Supprimer cette méditation ?')) router.delete(`/admin/meditations/${id}`);
}
</script>

<template>
    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-200">Gestion des Méditations</h2>
                <Link href="/admin/meditations/create" class="px-4 py-2 bg-green-500 hover:bg-green-400 text-black font-semibold rounded-lg text-sm">
                    + Nouvelle méditation
                </Link>
            </div>
        </template>
        <div class="py-8 px-4 max-w-6xl mx-auto">
            <div class="bg-gray-900/50 border border-gray-700/30 rounded-2xl overflow-hidden">
                <table class="w-full">
                    <thead class="border-b border-gray-700/30">
                        <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <th class="px-6 py-4">Titre</th>
                            <th class="px-6 py-4">Thème</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Écoutes</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        <tr v-for="m in meditations" :key="m.id" class="hover:bg-gray-800/30">
                            <td class="px-6 py-4 font-medium text-white">{{ m.title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ themeLabels[m.theme] }}</td>
                            <td class="px-6 py-4 text-sm text-gray-400 uppercase">{{ m.type }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ m.listen_count }}</td>
                            <td class="px-6 py-4">
                                <span :class="`text-xs px-2 py-1 rounded-full ${m.is_active ? 'bg-green-500/20 text-green-400' : 'bg-gray-700 text-gray-400'}`">
                                    {{ m.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex gap-3">
                                <Link :href="`/admin/meditations/${m.id}/edit`" class="text-sm text-blue-400 hover:text-blue-300">Éditer</Link>
                                <button @click="destroy(m.id)" class="text-sm text-red-400 hover:text-red-300">Supprimer</button>
                            </td>
                        </tr>
                        <tr v-if="!meditations?.length">
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">Aucune méditation.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
