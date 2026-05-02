<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Line, Bar, Doughnut } from 'vue-chartjs';
import {
    Chart as ChartJS,
    CategoryScale, LinearScale, PointElement, LineElement,
    BarElement, ArcElement, Title, Tooltip, Legend, Filler,
} from 'chart.js';
import { computed } from 'vue';

ChartJS.register(
    CategoryScale, LinearScale, PointElement, LineElement,
    BarElement, ArcElement, Title, Tooltip, Legend, Filler
);

const props = defineProps({
    stats: Object,
    recentOrders: Array,
    recentUsers: Array,
    monthlyRevenue: Array,
    contentStats: Object,
});

// KPI cards
const kpis = computed(() => [
    {
        label: 'Revenus totaux',
        value: `${Number(props.stats?.revenue ?? 0).toFixed(2)} €`,
        icon: '💰',
        color: 'from-green-900/40 to-emerald-900/20',
        border: 'border-green-800/40',
        badge: '+12% ce mois',
        badgeColor: 'text-green-400 bg-green-500/10',
    },
    {
        label: 'Utilisateurs',
        value: props.stats?.users ?? 0,
        icon: '👥',
        color: 'from-blue-900/40 to-blue-900/20',
        border: 'border-blue-800/40',
        badge: 'Total inscrits',
        badgeColor: 'text-blue-400 bg-blue-500/10',
    },
    {
        label: 'Abonnements actifs',
        value: props.stats?.subscriptions ?? 0,
        icon: '⭐',
        color: 'from-yellow-900/40 to-yellow-900/20',
        border: 'border-yellow-800/40',
        badge: 'En cours',
        badgeColor: 'text-yellow-400 bg-yellow-500/10',
    },
    {
        label: 'Commandes',
        value: props.stats?.orders ?? 0,
        icon: '🛒',
        color: 'from-purple-900/40 to-purple-900/20',
        border: 'border-purple-800/40',
        badge: 'Total traités',
        badgeColor: 'text-purple-400 bg-purple-500/10',
    },
]);

// Revenue line chart
const revenueData = computed(() => ({
    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
    datasets: [{
        label: 'Revenus (€)',
        data: props.monthlyRevenue ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        borderColor: '#22c55e',
        backgroundColor: 'rgba(34, 197, 94, 0.08)',
        borderWidth: 2,
        pointBackgroundColor: '#22c55e',
        pointRadius: 4,
        pointHoverRadius: 6,
        tension: 0.4,
        fill: true,
    }],
}));

const revenueOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { display: false },
        tooltip: {
            backgroundColor: '#111827',
            borderColor: '#16a34a',
            borderWidth: 1,
            titleColor: '#fff',
            bodyColor: '#9ca3af',
            callbacks: { label: ctx => ` ${ctx.raw} €` },
        },
    },
    scales: {
        x: {
            grid: { color: 'rgba(255,255,255,0.03)' },
            ticks: { color: '#6b7280', font: { size: 11 } },
        },
        y: {
            grid: { color: 'rgba(255,255,255,0.03)' },
            ticks: { color: '#6b7280', font: { size: 11 }, callback: v => v + ' €' },
        },
    },
};

// Content bar chart
const contentData = computed(() => ({
    labels: ['Services', 'Formations', 'Méditations', 'Articles'],
    datasets: [{
        label: 'Contenus',
        data: [
            props.stats?.services ?? 0,
            props.stats?.formations ?? 0,
            props.stats?.meditations ?? 0,
            props.stats?.articles ?? 0,
        ],
        backgroundColor: [
            'rgba(34, 197, 94, 0.7)',
            'rgba(16, 185, 129, 0.7)',
            'rgba(20, 184, 166, 0.7)',
            'rgba(6, 182, 212, 0.7)',
        ],
        borderColor: [
            'rgba(34, 197, 94, 1)',
            'rgba(16, 185, 129, 1)',
            'rgba(20, 184, 166, 1)',
            'rgba(6, 182, 212, 1)',
        ],
        borderWidth: 1,
        borderRadius: 6,
    }],
}));

const contentOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { display: false },
        tooltip: {
            backgroundColor: '#111827',
            borderColor: '#16a34a',
            borderWidth: 1,
            titleColor: '#fff',
            bodyColor: '#9ca3af',
        },
    },
    scales: {
        x: { grid: { display: false }, ticks: { color: '#6b7280', font: { size: 11 } } },
        y: { grid: { color: 'rgba(255,255,255,0.03)' }, ticks: { color: '#6b7280', font: { size: 11 }, stepSize: 1 } },
    },
};

// Doughnut chart (order status)
const doughnutData = computed(() => ({
    labels: ['Payées', 'En attente', 'Échouées'],
    datasets: [{
        data: [
            props.stats?.orders_paid ?? 0,
            props.stats?.orders_pending ?? 0,
            props.stats?.orders_failed ?? 0,
        ],
        backgroundColor: ['rgba(34,197,94,0.8)', 'rgba(234,179,8,0.8)', 'rgba(239,68,68,0.8)'],
        borderColor: ['#22c55e', '#eab308', '#ef4444'],
        borderWidth: 1,
        hoverOffset: 4,
    }],
}));

const doughnutOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'bottom',
            labels: { color: '#9ca3af', font: { size: 11 }, padding: 16, boxWidth: 12 },
        },
        tooltip: {
            backgroundColor: '#111827',
            borderColor: '#16a34a',
            borderWidth: 1,
            titleColor: '#fff',
            bodyColor: '#9ca3af',
        },
    },
    cutout: '72%',
};

const statusColors = {
    pending: 'text-yellow-400 bg-yellow-500/10 border-yellow-500/20',
    paid: 'text-green-400 bg-green-500/10 border-green-500/20',
    failed: 'text-red-400 bg-red-500/10 border-red-500/20',
    refunded: 'text-gray-400 bg-gray-500/10 border-gray-500/20',
};
const statusLabels = { pending: 'En attente', paid: 'Payée', failed: 'Échouée', refunded: 'Remboursée' };

function formatDate(d) {
    return new Date(d).toLocaleDateString('fr-FR', { day: '2-digit', month: 'short' });
}
</script>

<template>
    <AdminLayout>
        <template #header>
            <div>
                <h1 class="text-lg font-bold text-white">Dashboard</h1>
                <p class="text-xs text-gray-500">Vue d'ensemble de votre plateforme</p>
            </div>
        </template>

        <div class="space-y-8">

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                <div
                    v-for="kpi in kpis"
                    :key="kpi.label"
                    :class="`bg-gradient-to-br ${kpi.color} border ${kpi.border} rounded-2xl p-5 relative overflow-hidden`"
                >
                    <div class="absolute top-0 right-0 w-24 h-24 opacity-5">
                        <div class="text-8xl">{{ kpi.icon }}</div>
                    </div>
                    <div class="text-2xl mb-2">{{ kpi.icon }}</div>
                    <div class="text-3xl font-bold text-white mb-1">{{ kpi.value }}</div>
                    <div class="text-sm text-gray-400">{{ kpi.label }}</div>
                    <span :class="`mt-3 inline-block text-xs font-medium px-2 py-0.5 rounded-full ${kpi.badgeColor}`">
                        {{ kpi.badge }}
                    </span>
                </div>
            </div>

            <!-- Charts row -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <!-- Revenue Line Chart -->
                <div class="xl:col-span-2 bg-gray-900/60 border border-green-900/20 rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-base font-semibold text-white">Revenus mensuels</h2>
                            <p class="text-xs text-gray-500 mt-0.5">Évolution sur l'année</p>
                        </div>
                        <span class="text-xs text-green-400 bg-green-500/10 border border-green-500/20 px-2 py-1 rounded-lg">
                            {{ new Date().getFullYear() }}
                        </span>
                    </div>
                    <div class="h-56">
                        <Line :data="revenueData" :options="revenueOptions" />
                    </div>
                </div>

                <!-- Doughnut -->
                <div class="bg-gray-900/60 border border-green-900/20 rounded-2xl p-6">
                    <div class="mb-6">
                        <h2 class="text-base font-semibold text-white">Statut commandes</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Répartition globale</p>
                    </div>
                    <div class="h-56 flex items-center justify-center">
                        <Doughnut :data="doughnutData" :options="doughnutOptions" />
                    </div>
                </div>
            </div>

            <!-- Content Bar + Quick stats -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <!-- Bar chart -->
                <div class="bg-gray-900/60 border border-green-900/20 rounded-2xl p-6">
                    <div class="mb-6">
                        <h2 class="text-base font-semibold text-white">Contenus publiés</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Par catégorie</p>
                    </div>
                    <div class="h-48">
                        <Bar :data="contentData" :options="contentOptions" />
                    </div>
                </div>

                <!-- Recent orders -->
                <div class="xl:col-span-2 bg-gray-900/60 border border-green-900/20 rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-base font-semibold text-white">Commandes récentes</h2>
                            <p class="text-xs text-gray-500 mt-0.5">Dernières transactions</p>
                        </div>
                        <a href="/admin/orders" class="text-xs text-green-400 hover:text-green-300 transition-colors">Voir tout →</a>
                    </div>
                    <div v-if="recentOrders?.length" class="space-y-3">
                        <div
                            v-for="order in recentOrders"
                            :key="order.id"
                            class="flex items-center gap-4 p-3 rounded-xl bg-gray-800/40 hover:bg-gray-800/70 transition-colors"
                        >
                            <div class="w-9 h-9 bg-green-500/10 border border-green-500/20 rounded-lg flex items-center justify-center text-green-400 font-bold text-xs flex-shrink-0">
                                {{ order.user?.name?.charAt(0)?.toUpperCase() }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-white truncate">{{ order.user?.name }}</p>
                                <p class="text-xs text-gray-500 font-mono">{{ order.reference }}</p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-sm font-bold text-white">{{ order.amount }} €</p>
                                <p class="text-xs text-gray-500">{{ formatDate(order.created_at) }}</p>
                            </div>
                            <span :class="`text-xs border px-2 py-0.5 rounded-full font-medium ${statusColors[order.status]}`">
                                {{ statusLabels[order.status] }}
                            </span>
                        </div>
                    </div>
                    <div v-else class="flex flex-col items-center justify-center py-8 text-gray-600">
                        <svg class="w-10 h-10 mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p class="text-sm">Aucune commande pour le moment</p>
                    </div>
                </div>
            </div>

            <!-- Bottom row: Recent users + Quick actions -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <!-- Recent users -->
                <div class="xl:col-span-2 bg-gray-900/60 border border-green-900/20 rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-base font-semibold text-white">Nouveaux membres</h2>
                            <p class="text-xs text-gray-500 mt-0.5">Dernières inscriptions</p>
                        </div>
                        <a href="/admin/users" class="text-xs text-green-400 hover:text-green-300 transition-colors">Voir tout →</a>
                    </div>
                    <div v-if="recentUsers?.length" class="space-y-3">
                        <div
                            v-for="u in recentUsers"
                            :key="u.id"
                            class="flex items-center gap-4 p-3 rounded-xl bg-gray-800/40 hover:bg-gray-800/70 transition-colors"
                        >
                            <div class="w-9 h-9 bg-green-500/10 border border-green-500/20 rounded-full flex items-center justify-center text-green-400 font-bold text-sm flex-shrink-0">
                                {{ u.name?.charAt(0)?.toUpperCase() }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-white">{{ u.name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ u.email }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span :class="`text-xs border px-2 py-0.5 rounded-full ${u.role === 'admin' ? 'text-red-400 border-red-500/30 bg-red-500/10' : 'text-gray-400 border-gray-600 bg-gray-800'}`">
                                    {{ u.role }}
                                </span>
                                <span class="text-xs text-gray-600">{{ formatDate(u.created_at) }}</span>
                            </div>
                        </div>
                    </div>
                    <p v-else class="text-center text-gray-600 text-sm py-8">Aucun utilisateur.</p>
                </div>

                <!-- Quick actions -->
                <div class="bg-gray-900/60 border border-green-900/20 rounded-2xl p-6">
                    <h2 class="text-base font-semibold text-white mb-6">Actions rapides</h2>
                    <div class="space-y-3">
                        <a href="/admin/services/create"
                            class="flex items-center gap-3 p-3 rounded-xl bg-gray-800/40 hover:bg-green-900/20 border border-transparent hover:border-green-900/30 transition-all group">
                            <span class="w-8 h-8 bg-green-500/10 rounded-lg flex items-center justify-center text-green-400 group-hover:bg-green-500/20 transition-colors">🎙️</span>
                            <span class="text-sm text-gray-300 group-hover:text-white transition-colors">Nouveau service</span>
                        </a>
                        <a href="/admin/formations/create"
                            class="flex items-center gap-3 p-3 rounded-xl bg-gray-800/40 hover:bg-green-900/20 border border-transparent hover:border-green-900/30 transition-all group">
                            <span class="w-8 h-8 bg-green-500/10 rounded-lg flex items-center justify-center text-green-400 group-hover:bg-green-500/20 transition-colors">🎓</span>
                            <span class="text-sm text-gray-300 group-hover:text-white transition-colors">Nouvelle formation</span>
                        </a>
                        <a href="/admin/meditations/create"
                            class="flex items-center gap-3 p-3 rounded-xl bg-gray-800/40 hover:bg-green-900/20 border border-transparent hover:border-green-900/30 transition-all group">
                            <span class="w-8 h-8 bg-green-500/10 rounded-lg flex items-center justify-center text-green-400 group-hover:bg-green-500/20 transition-colors">🧘</span>
                            <span class="text-sm text-gray-300 group-hover:text-white transition-colors">Nouvelle méditation</span>
                        </a>
                        <a href="/admin/articles/create"
                            class="flex items-center gap-3 p-3 rounded-xl bg-gray-800/40 hover:bg-green-900/20 border border-transparent hover:border-green-900/30 transition-all group">
                            <span class="w-8 h-8 bg-green-500/10 rounded-lg flex items-center justify-center text-green-400 group-hover:bg-green-500/20 transition-colors">✍️</span>
                            <span class="text-sm text-gray-300 group-hover:text-white transition-colors">Nouvel article</span>
                        </a>
                        <a href="/" target="_blank"
                            class="flex items-center gap-3 p-3 rounded-xl bg-gray-800/40 hover:bg-blue-900/20 border border-transparent hover:border-blue-900/30 transition-all group">
                            <span class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center text-blue-400 group-hover:bg-blue-500/20 transition-colors">🌐</span>
                            <span class="text-sm text-gray-300 group-hover:text-white transition-colors">Voir le site</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </AdminLayout>
</template>
