<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({ formations: Array });
const levelLabels = { debutant: 'Débutant', intermediaire: 'Intermédiaire', avance: 'Avancé' };

function destroy(id) {
    if (confirm('Supprimer cette formation ?')) router.delete(`/admin/formations/${id}`);
}
</script>

<template>
    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-200">Gestion des Formations</h2>
                <Link href="/admin/formations/create" class="px-4 py-2 bg-green-500 hover:bg-green-400 text-black font-semibold rounded-lg text-sm">
                    + Nouvelle formation
                </Link>
            </div>
        </template>
        <div class="py-8 px-4 max-w-6xl mx-auto">
            <div class="bg-gray-900/50 border border-gray-700/30 rounded-2xl overflow-hidden">
                <table class="w-full">
                    <thead class="border-b border-gray-700/30">
                        <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <th class="px-6 py-4">Titre</th>
                            <th class="px-6 py-4">Niveau</th>
                            <th class="px-6 py-4">Prix</th>
                            <th class="px-6 py-4">Durée</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        <tr v-for="f in formations" :key="f.id" class="hover:bg-gray-800/30">
                            <td class="px-6 py-4 font-medium text-white">{{ f.title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ levelLabels[f.level] }}</td>
                            <td class="px-6 py-4 text-green-400 font-semibold">{{ f.price }} €</td>
                            <td class="px-6 py-4 text-gray-400">{{ f.duration_hours ? f.duration_hours + 'h' : '—' }}</td>
                            <td class="px-6 py-4">
                                <span :class="`text-xs px-2 py-1 rounded-full ${f.is_active ? 'bg-green-500/20 text-green-400' : 'bg-gray-700 text-gray-400'}`">
                                    {{ f.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex gap-3">
                                <Link :href="`/admin/formations/${f.id}/edit`" class="text-sm text-blue-400 hover:text-blue-300">Éditer</Link>
                                <button @click="destroy(f.id)" class="text-sm text-red-400 hover:text-red-300">Supprimer</button>
                            </td>
                        </tr>
                        <tr v-if="!formations?.length">
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">Aucune formation.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
