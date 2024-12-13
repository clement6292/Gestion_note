<template>
  <Head title="Dashboard" />
  <AuthenticatedLayout>
    <div class="max-w-4xl mx-auto p-6">
      <div class="bg-blue-600 text-white p-4 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold">Bienvenue dans votre application!</h1>
      </div>

      <div class="mt-4 mb-6">
        <button
          @click="goToCreateNote"
          class="inline-block bg-green-500 text-white px-4 py-2 rounded-lg shadow hover:bg-green-600 transition duration-200"
        >
          Créer une Note
        </button>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div
          v-for="note in notes.data"
          :key="note.id"
          class="bg-white border border-gray-200 rounded-lg shadow p-4 hover:shadow-lg transition duration-200"
        >
          <img
            v-if="note.image_path"
            :src="'/storage/' + note.image_path"
            alt="Image de la note"
            class="mt-2 w-full h-auto rounded-md"
          />
          <h2 class="text-xl font-semibold text-gray-800">{{ note.title }}</h2>
          <p class="text-gray-600">{{ note.content }}</p>
          <p class="text-sm text-gray-500"><strong>Catégorie:</strong> {{ note.category.name }}</p>
          <p class="text-xs text-gray-400"><strong>Date de création:</strong> {{ new Date(note.created_at).toLocaleDateString() }}</p>

          <div class="mt-4 flex space-x-2">
            <button
              @click="deleteNote(note.id)"
              class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition duration-200"
            >
              Supprimer
            </button>
            <button
              @click="editNote(note)"
              class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition duration-200"
            >
              Modifier
            </button>
          </div>
        </div>
      </div>

      <!-- Pagination Links -->
      <div class="mt-6">
        <ul class="flex justify-center space-x-2">
          <li v-if="notes.current_page > 1">
            <button @click="goToPage(notes.current_page - 1)" class="bg-gray-300 px-4 py-2 rounded">Précédent</button>
          </li>
          <li v-for="page in Array.from({ length: notes.last_page }, (_, i) => i + 1)" :key="page">
            <button @click="goToPage(page)" class="bg-gray-300 px-4 py-2 rounded">{{ page }}</button>
          </li>
          <li v-if="notes.current_page < notes.last_page">
            <button @click="goToPage(notes.current_page + 1)" class="bg-gray-300 px-4 py-2 rounded">Suivant</button>
          </li>
        </ul>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import Toastify from 'toastify-js'; // Importer Toastify

const props = defineProps(['notes']); // Récupérer les notes passées par Inertia

const editNote = (note) => {
  Inertia.visit(`/notes/${note.id}/edit`); // Rediriger vers la page d'édition de la note
};

const goToCreateNote = () => {
  Inertia.visit('/create-note'); // Rediriger vers la page de création de note
};

const goToPage = (page) => {
  Inertia.get('/notes', { page }); // Charge la page spécifiée
};

const deleteNote = (id) => {
  Toastify({
    text: "Êtes-vous sûr de vouloir supprimer cette note ?",
    duration: 5000,
    close: true,
    gravity: "top",
    position: "center",
    backgroundColor: "#ff9800",
    onClick: () => { // Action lors du clic sur la notification
      Inertia.delete(`/notes/${id}`, {
        onSuccess: () => {
          Toastify({
            text: "Note supprimée avec succès!",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#4caf50",
          }).showToast();
        },
        onError: () => {
          Toastify({
            text: "Erreur lors de la suppression de la note.",
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: "#f44336",
          }).showToast();
        },
      });
    },
  }).showToast();
};
</script>

<style scoped>
.grid {
  display: grid;
  gap: 16px;
}
</style>