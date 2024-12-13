<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-center text-gray-800">Créer un compte</h2>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="name" value="Nom" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full border border-gray-300 rounded-md focus:ring focus:ring-indigo-500"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Email" />
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full border border-gray-300 rounded-md focus:ring focus:ring-indigo-500"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Mot de passe" />
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full border border-gray-300 rounded-md focus:ring focus:ring-indigo-500"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Confirmer le mot de passe" />
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full border border-gray-300 rounded-md focus:ring focus:ring-indigo-500"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div class="mt-4 flex items-center justify-end">
                    <Link
                        :href="route('login')"
                        class="text-sm text-indigo-600 hover:text-indigo-900"
                    >
                        Déjà inscrit ?
                    </Link>
                    <PrimaryButton
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 ms-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        S'inscrire
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>