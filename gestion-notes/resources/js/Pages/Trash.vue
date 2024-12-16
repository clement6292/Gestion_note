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
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">{{ note.title }}</h2>
                        <p class="text-gray-600">{{ note.content }}</p>
                    </div>
                    <form @submit.prevent="restoreNote(note.id)">
                        <button
                            type="submit"
                            class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-200"
                        >
                            Restaurer
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        <div class="mt-6 text-center">
            <a href="/notes" class="text-blue-500 hover:underline">Retourner à mes notes</a>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        deletedNotes: Array,
    },
    methods: {
        restoreNote(id) {
            this.$inertia.post(`/notes/${id}/restore`);
        },
    },
};
</script>

<style scoped>
/* Vous pouvez ajouter des styles supplémentaires ici si nécessaire */
</style>