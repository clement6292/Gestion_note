<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

// Importer des composants de graphique si nécessaire
// import { Bar } from 'vue-chartjs';

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tableau de bord
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Section des cartes -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Carte 1: Statistique -->
                    <div class="overflow-hidden bg-gradient-to-r from-blue-500 to-indigo-500 shadow-lg rounded-lg p-6 text-white">
                        <h3 class="text-lg font-bold">Utilisateurs</h3>
                        <p class="text-3xl font-semibold">1,245</p>
                        <p class="text-sm">Nouveaux utilisateurs ce mois-ci</p>
                    </div>

                    <!-- Carte 2: Statistique -->
                    <div class="overflow-hidden bg-gradient-to-r from-green-400 to-green-600 shadow-lg rounded-lg p-6 text-white">
                        <h3 class="text-lg font-bold">Ventes</h3>
                        <p class="text-3xl font-semibold">$32,500</p>
                        <p class="text-sm">Total des ventes ce trimestre</p>
                    </div>

                    <!-- Carte 3: Statistique -->
                    <div class="overflow-hidden bg-gradient-to-r from-red-500 to-red-600 shadow-lg rounded-lg p-6 text-white">
                        <h3 class="text-lg font-bold">Tickets de Support</h3>
                        <p class="text-3xl font-semibold">12</p>
                        <p class="text-sm">Tickets ouverts actuellement</p>
                    </div>

                    <!-- Carte 4: Notifications -->
                    <div class="overflow-hidden bg-gradient-to-r from-purple-500 to-purple-600 shadow-lg rounded-lg p-6 text-white">
                        <h3 class="text-lg font-bold">Notifications</h3>
                        <ul class="mt-4 space-y-2">
                            <li>🔔 Nouvelle mise à jour disponible</li>
                            <li>🔔 3 nouveaux messages</li>
                            <li>🔔 Rappel: Vérifiez votre profil</li>
                        </ul>
                    </div>
                </div>

                <!-- Section Graphique -->
                <div class="mt-8 bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-700">Statistiques des Ventes</h3>
                    <div class="mt-4">
                        <!-- Ici, vous pouvez intégrer un graphique, par exemple avec Chart.js -->
                        <!-- <BarChart /> -->
                        <div class="h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                            <p class="text-gray-500">Graphique à intégrer ici</p>
                        </div>
                    </div>
                </div>

                <!-- Message de Bienvenue -->
                <div class="mt-8 bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-700">Bienvenue sur votre tableau de bord!</h3>
                    <p class="mt-2 text-gray-600">
                        Vous êtes connecté et prêt à gérer vos tâches avec efficacité.
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Ajoutez des animations et des effets si nécessaire */
.grid > div {
    transition: transform 0.2s;
}

.grid > div:hover {
    transform: scale(1.05);
}
</style>