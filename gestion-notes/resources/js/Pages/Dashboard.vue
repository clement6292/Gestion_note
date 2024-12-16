<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps(['totalNotes', 'trashedNotesCount']);
</script>

<template>
    <Head title="Tableau de bord" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tableau de bord
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Carte 1: Total des Notes -->
                    <div class="overflow-hidden bg-white shadow-lg rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-700">Total des Notes</h3>
                           <p class="text-3xl font-semibold text-indigo-600">{{ totalNotes }}</p>
                            <p class="text-gray-500">Toutes vos notes enregistrées</p>
                        </div>
                    </div>

                    <!-- Carte 2: Notes Épinglées -->
                  

                    <!-- Carte 3: Notes dans la Corbeille -->
                    <div class="overflow-hidden bg-white shadow-lg rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-700">Notes dans la Corbeille</h3>
                            <p class="text-3xl font-semibold text-red-600">{{ trashedNotesCount }}</p>
                            <p class="text-gray-500">Notes supprimées récemment</p>
                        </div>
                    </div>

                    <!-- Carte 4: Notifications -->
                    <div class="overflow-hidden bg-white shadow-lg rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-700">Dernières Notifications</h3>
                            <ul class="mt-4 space-y-2">
                                <li class="text-gray-600">🔔 Nouvelle fonctionnalité ajoutée : étiquettes</li>
                                <li class="text-gray-600">🔔 Astuce : Utilisez les catégories pour organiser vos notes</li>
                                <li class="text-gray-600">🔔 Pensez à vider votre corbeille régulièrement</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Message de Bienvenue -->
                <div class="mt-8 bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-700">Bienvenue sur votre tableau de bord !</h3>
                    <p class="mt-2 text-gray-600">
                        Retrouvez toutes vos notes en un seul endroit. Créez, gérez et organisez vos idées en toute simplicité.
                    </p>
                    <p class="mt-2 text-gray-600">
                        Besoin d'aide ? Consultez notre <a href="#" class="text-indigo-600 hover:underline">centre de support</a>.
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


