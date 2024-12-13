<template>
  <Head title="Edit notes" />
  <AuthenticatedLayout>
    <div class="max-w-2xl mx-auto p-6">
      <h1 class="text-2xl font-bold">Mettre à jour la Note</h1>
       <!-- <div v-if="!note || !categories.length">
        <p>Erreur: Les données ne sont pas disponibles.</p>
      </div> -->
      <form @submit.prevent="updateNote" class="mt-6 bg-white p-6 rounded-lg shadow-md">
        <div class="space-y-4">
          <input
            v-model="note.title"
            placeholder="Titre"
            required
            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          
          <textarea
            v-model="note.content"
            placeholder="Contenu"
            required
            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          ></textarea>
          
          <select
            v-model="note.category_id" 
            required
            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <option value="" disabled>Sélectionnez une catégorie</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
          
          <input
            type="file"
            @change="onFileChange"
            class="w-full border border-gray-300 rounded-lg p-2"
          />
          
          <button
            type="submit"
            class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200"
          >
            Mettre à jour Note
          </button>
        </div>
      </form>
    </div>
  </AuthenticatedLayout>
</template>




<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'; // Vérifiez ce chemin aussi

const props = defineProps(['note', 'categories']);
const note = ref({ ...props.note });

const updateNote = async () => {
  const formData = new FormData();
  formData.append('title', note.value.title);
  formData.append('content', note.value.content);
  formData.append('category_id', note.value.category_id); // Assurez-vous que c'est category_id

  if (note.value.image) {
    formData.append('image', note.value.image);
  }

  try {
    await Inertia.put(`/notes/${note.value.id}`, formData, {
      onError: (errors) => {
        console.error("Erreurs de validation:", errors);
        alert("Erreur de validation : " + Object.values(errors).join(", "));
      }
    });
  } catch (error) {
    console.error("Erreur lors de la mise à jour de la note:", error);
  }
};

const onFileChange = (event) => {
  note.value.image = event.target.files[0];
};

const goBack = () => {
  Inertia.visit('/notes'); // Redirige vers la page des notes
};
</script>

<style scoped>
/* Ajoutez vos styles spécifiques ici si nécessaire */
</style>