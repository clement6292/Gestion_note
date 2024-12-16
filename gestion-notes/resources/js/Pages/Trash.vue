<template>
  <div class="max-w-4xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-6 text-blue-600">🗑️ Corbeille</h1>
    <div class="bg-white shadow-md rounded-lg p-6">
      <ul class="space-y-4">
        <li
          v-for="note in deletedNotes"
          :key="note.id"
          class="flex justify-between items-center p-4 border-b border-gray-200 hover:bg-gray-100 rounded-lg transition duration-200"
        >
          <div class="flex-grow">
            <h2 class="text-xl font-semibold text-gray-800">{{ note.title }}</h2>
            <p class="text-gray-600">{{ note.content }}</p>
            <!-- <img v-if="note.image_path" :src="note.image_path" alt="Image de la note" class="mt-2 rounded" /> -->
          </div>
          <div class="flex space-x-2">
            <form @submit.prevent="restoreNote(note.id)">
              <button
                type="submit"
                class="relative bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-200"
              >
                <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" width="30px" height="30px" viewBox="0 0 24 24">
                  <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm-2 16c-2.05 0-3.81-1.24-4.58-3h1.71c.63.9 1.68 1.5 2.87 1.5 1.93 0 3.5-1.57 3.5-3.5S13.93 9.5 12 9.5c-1.35 0-2.52.78-3.1 1.9l1.6 1.6h-4V9l1.3 1.3C8.69 8.92 10.23 8 12 8c2.76 0 5 2.24 5 5s-2.24 5-5 5z"/>
                </svg>
                <span class="absolute left-0 transform -translate-x-full bg-gray-800 text-white text-xs rounded px-2 py-1 opacity-0 transition-opacity duration-200 hover:opacity-100">Restaurer</span>
              </button>
            </form>
            <button
              @click="openModal(note.id)"
              class="relative bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-200"
            >
              <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 12V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M14 12V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M6 10V18C6 19.6569 7.34315 21 9 21H15C16.6569 21 18 19.6569 18 18V10" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              <span class="absolute left-0 transform -translate-x-full bg-gray-800 text-white text-xs rounded px-2 py-1 opacity-0 transition-opacity duration-200 hover:opacity-100">Supprimer Définitivement</span>
            </button>
          </div>
        </li>
      </ul>
    </div>
    <div class="mt-6 text-center">
      <a href="/notes" class="text-blue-500 hover:underline">Retourner à mes notes</a>
    </div>

    <!-- Modal -->
    <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
      <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
        <h2 class="text-xl font-bold mb-4">Confirmer la Suppression</h2>
        <p>Êtes-vous sûr de vouloir supprimer cette note définitivement ?</p>
        <div class="mt-4 flex justify-end">
          <button @click="closeModal" class="mr-2 px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Annuler</button>
          <button @click="confirmDelete" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Confirmer</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { defineProps } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  deletedNotes: Array,
});

const isModalOpen = ref(false);
const noteIdToDelete = ref(null);

// Ouvrir le modal
const openModal = (id) => {
  noteIdToDelete.value = id;
  isModalOpen.value = true;
};

// Fermer le modal
const closeModal = () => {
  isModalOpen.value = false;
  noteIdToDelete.value = null;
};

// Confirmer la suppression
const confirmDelete = () => {
  if (noteIdToDelete.value) {
    Inertia.delete(`/notes/${noteIdToDelete.value}/force-delete`);
  }
  closeModal();
};

const restoreNote = (id) => {
  Inertia.post(`/notes/${id}/restore`);
};
</script>

<style scoped>
/* Ajoutez des styles supplémentaires si nécessaire */
</style>