<template>
  <div class="flex flex-col items-center justify-center h-screen bg-gray-100">
    <h1 class="text-4xl font-bold mb-4">Bienvenue dans votre application de gestion de notes!</h1>
    <p class="mb-8 text-lg">Connectez-vous pour commencer à gérer vos notes.</p>

    <div class="flex space-x-4">
      <Link
        href="/login"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
      >
        Se connecter
      </Link>
      <Link
        href="/register"
        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition"
      >
        S'inscrire
      </Link>
    </div>
  </div>
</template>

<script setup>
// Importer le composant Link d'Inertia
import { Link } from '@inertiajs/inertia-vue3';
</script>

<style scoped>
/* Ajoutez vos styles spécifiques ici si nécessaire */
</style>