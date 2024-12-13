<template>
  <Head title="Créer une Note" />
  <AuthenticatedLayout>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <div class="max-w-2xl w-full p-6 bg-white rounded-lg shadow-lg">
        <div class="bg-blue-600 text-white p-4 rounded-lg shadow-md">
          <h1 class="text-2xl font-bold">Créer une Note</h1>
        </div>
        
        <form @submit.prevent="addNote" class="mt-6">
          <div class="space-y-4">
            <input
              v-model="newNote.title"
              placeholder="Titre"
              required
              class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
            />
            
            <textarea
              v-model="newNote.content"
              placeholder="Contenu"
              required
              class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
            ></textarea>
            
            <select
              v-model="newNote.category"
              required
              class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
            >
              <option value="" disabled selected>Sélectionnez une catégorie</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
            
            <input
              type="file"
              @change="onFileChange"
              class="w-full border border-gray-300 rounded-lg p-3 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            
            <button
              type="submit"
              class="w-full bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-200"
            >
              Ajouter Note
            </button>
          </div>
        </form>

        <div class="mt-4 text-center">
          <button
            @click="goBack"
            class="text-blue-500 hover:underline transition duration-200"
          >
            Retourner aux notes
          </button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';

// État pour la nouvelle note
const newNote = ref({
  title: '',
  content: '',
  category: '',
  image: null,
});

// État pour les catégories
const categories = ref([]);

// Fonction pour récupérer les catégories depuis l'API
const fetchCategories = async () => {
  try {
    const response = await fetch('/categories'); // Vérifiez que cette route fonctionne correctement
    categories.value = await response.json();
  } catch (error) {
    console.error("Erreur lors de la récupération des catégories:", error);
  }
};

// Fonction pour ajouter une nouvelle note
const addNote = async () => {
  const formData = new FormData();
  formData.append('title', newNote.value.title);
  formData.append('content', newNote.value.content);
  formData.append('category', newNote.value.category);
  
  // Ajouter l'image si elle est présente
  if (newNote.value.image) {
    formData.append('image', newNote.value.image);
  }

  try {
    // Soumettre le formulaire et rediriger vers la page des notes après la création
    await Inertia.post('/notes', formData, {
      onSuccess: () => {
        Inertia.visit('/notes'); // Redirige vers la page des notes
      },
      onError: (errors) => {
        console.error("Erreur lors de l'ajout de la note:", errors);
      }
    });
  } catch (error) {
    console.error("Erreur lors de la soumission:", error);
  }
};

// Fonction pour gérer le changement de fichier
const onFileChange = (event) => {
  newNote.value.image = event.target.files[0];
};

// Fonction pour revenir à la liste des notes
const goBack = () => {
  Inertia.visit('/notes'); // Redirige vers la page des notes
};

// Récupérer les catégories lors du montage du composant
onMounted(fetchCategories);
</script>

<style scoped>
/* Ajoutez vos styles spécifiques ici si nécessaire */
</style>