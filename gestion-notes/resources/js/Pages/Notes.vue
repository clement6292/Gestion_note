<template>
  <Head title="Dashboard" />
  <AuthenticatedLayout>
    <div class="max-w-4xl mx-auto p-6">
      <div class="bg-blue-600 text-white p-4 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold">Bienvenue dans votre application!</h1>
      </div>

      <div class="mt-4 mb-6 flex space-x-8">
        <button
          @click="goToDashboard"
          class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition duration-200"
        >
          Accéder au Tableau de Bord
        </button>

        <button
          @click="goToCreateNote"
          class="bg-green-500 text-white px-4 py-2 rounded-lg shadow hover:bg-green-600 transition duration-200 flex items-center space-x-2"
        >
          <svg
            width="20px"
            height="20px"
            viewBox="0 0 16 16"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path d="M10 1H6V6L1 6V10H6V15H10V10H15V6L10 6V1Z" fill="#000000" />
          </svg>
          <span>Créer une nouvelle Note</span>
        </button>
      </div>

      <!-- Champ de recherche par titre -->
      <div class="mb-4 relative">
        <!-- Conteneur relatif pour le positionnement -->
        <input
          v-model="searchQuery"
          @input="filterNotes"
          type="text"
          placeholder="Rechercher par titre"
          class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10"
        />
        <div class="absolute right-2 top-1/2 transform -translate-y-1/2">
          <!-- Positionnement du SVG -->
          <svg
            width="20px"
            height="20px"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M16.6725 16.6412L21 21M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z"
              stroke="#000000"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
        </div>
      </div>

      <!-- Sélecteur de date -->
      <div class="mb-4">
        <input
          type="date"
          v-model="filterDate"
          @change="filterNotes"
          class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div
          v-for="note in filteredNotes"
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
          <p class="text-sm text-gray-500">
            <strong>Catégorie:</strong> {{ note.category.name }}
          </p>
          <p class="text-xs text-gray-400">
            <strong>Date de création:</strong>
            {{ new Date(note.created_at).toLocaleDateString() }}
          </p>

          <div class="mt-4 flex space-x-2">
            <button
              @click="confirmDelete(note.id)"
              class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition duration-200 flex items-center space-x-2"
            >
              <svg
                width="20px"
                height="20px"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16"
                  stroke="#000000"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
              <span>Supprimer</span>
              <!-- Texte encapsulé dans un <span> -->
            </button>
            <button
              @click="editNote(note)"
              class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition duration-200 flex items-center space-x-2"
            >
              <svg
                width="20px"
                height="20px"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M3 17.25V21h3.75L16.29 10.74l-3.75-3.75L3 17.25zM20.71 4.29a1 1 0 0 0 0-1.42l-2.58-2.58a1 1 0 0 0-1.42 0L15.29 1.71l3.75 3.75 1.42-1.42z"
                  fill="#FFF"
                />
              </svg>
              <span>Modifier</span>
              <!-- Texte encapsulé dans un <span> -->
            </button>
          </div>
        </div>
      </div>

      <!-- Pagination Links -->
      <div class="mt-6">
        <ul class="flex justify-center space-x-2">
          <li v-if="notes.current_page > 1">
            <button
              @click="goToPage(notes.current_page - 1)"
              class="bg-gray-300 px-4 py-2 rounded"
            >
              Précédent
            </button>
          </li>
          <li
            v-for="page in Array.from(
              { length: notes.last_page },
              (_, i) => i + 1
            )"
            :key="page"
          >
            <button
              @click="goToPage(page)"
              class="bg-gray-300 px-4 py-2 rounded"
            >
              {{ page }}
            </button>
          </li>
          <li v-if="notes.current_page < notes.last_page">
            <button
              @click="goToPage(notes.current_page + 1)"
              class="bg-gray-300 px-4 py-2 rounded"
            >
              Suivant
            </button>
          </li>
        </ul>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import { Inertia } from "@inertiajs/inertia";
import Toastify from "toastify-js";

const props = defineProps(["notes"]);

const searchQuery = ref("");
const filterDate = ref("");

const filteredNotes = computed(() => {
  return props.notes.data.filter((note) => {
    const matchesTitle = note.title
      .toLowerCase()
      .includes(searchQuery.value.toLowerCase());

    if (filterDate.value) {
      const noteDate = new Date(note.created_at).toISOString().split("T")[0];
      return matchesTitle && noteDate === filterDate.value;
    }
    return matchesTitle;
  });
});

const filterNotes = () => {};

const editNote = (note) => {
  Inertia.visit(`/notes/${note.id}/edit`);
};

const goToCreateNote = () => {
  Inertia.visit("/create-note");
};

const goToPage = (page) => {
  Inertia.get("/notes", { page });
};

const goToDashboard = () => {
  Inertia.visit("/dashboard");
};

const confirmDelete = (id) => {
  Toastify({
    text: "Êtes-vous sûr de vouloir supprimer cette note ?",
    duration: 5000,
    close: true,
    gravity: "top",
    position: "center",
    backgroundColor: "#ff9800",
    onClick: () => {
      deleteNote(id);
    },
  }).showToast();
};

const deleteNote = (id) => {
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
};
</script>

<style scoped>
.grid {
  display: grid;
  gap: 16px;
}
</style>