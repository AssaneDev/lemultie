<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    services: Array,
});

const categoryLabels = {
    copywriting: 'Copywriting', voix_off: 'Voix Off', percussion: 'Percussions',
    conte: 'Contes', meditation: 'Méditations', formation: 'Formations', conference: 'Conférences',
};

function destroy(id) {
    if (confirm('Supprimer ce service ?')) {
        router.delete(`/admin/services/${id}`);
    }
}
</script>

<template>
    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-200">Gestion des Services</h2>
                <Link href="/admin/services/create" class="px-4 py-2 bg-green-500 hover:bg-green-400 text-black font-semibold rounded-lg text-sm transition-colors">
                    + Nouveau service
                </Link>
            </div>
        </template>

        <div class="py-8 px-4 max-w-6xl mx-auto">
            <div class="bg-gray-900/50 border border-gray-700/30 rounded-2xl overflow-hidden">
                <table class="w-full">
                    <thead class="border-b border-gray-700/30">
                        <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            <th class="px-6 py-4">Titre</th>
                            <th class="px-6 py-4">Catégorie</th>
                            <th class="px-6 py-4">Prix</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        <tr v-for="service in services" :key="service.id" class="hover:bg-gray-800/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-white">{{ service.title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ categoryLabels[service.category] }}</td>
                            <td class="px-6 py-4 text-green-400">{{ service.price ? service.price + ' €' : '—' }}</td>
                            <td class="px-6 py-4">
                                <span :class="`text-xs px-2 py-1 rounded-full font-medium ${service.is_active ? 'bg-green-500/20 text-green-400' : 'bg-gray-700 text-gray-400'}`">
                                    {{ service.is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <Link :href="`/admin/services/${service.id}/edit`" class="text-sm text-blue-400 hover:text-blue-300">Éditer</Link>
                                <button @click="destroy(service.id)" class="text-sm text-red-400 hover:text-red-300">Supprimer</button>
                            </td>
                        </tr>
                        <tr v-if="!services?.length">
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Aucun service pour le moment.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>
