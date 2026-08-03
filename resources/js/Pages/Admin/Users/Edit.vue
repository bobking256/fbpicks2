<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import admin from '@/routes/admin';

const props = defineProps({
    user: Object,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    pick531: !!props.user.pick531,
    pickall: !!props.user.pickall,
    admin: !!props.user.admin,
});

const submit = () => {
    form.put(admin.updateuser(props.user.id).url);
};
</script>

<template>
    <Head title="Edit User" />

    <AppLayout>
        <template #header>
            <h2 class="font-display font-semibold text-xl text-nfl-navy-800 tracking-wide leading-tight">Edit User</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-8 py-6">
                    <form @submit.prevent="submit">
                        <div class="md:flex md:items-center mb-6">
                            <div class="md:w-1/3">
                                <InputLabel value="Username" />
                            </div>
                            <div class="md:w-2/3">
                                <TextInput v-model="form.name" type="text" class="w-full" />
                                <InputError :message="form.errors.name" />
                            </div>
                        </div>
                        <div class="md:flex md:items-center mb-6">
                            <div class="md:w-1/3">
                                <InputLabel value="Email" />
                            </div>
                            <div class="md:w-2/3">
                                <TextInput v-model="form.email" type="text" class="w-full" />
                                <InputError :message="form.errors.email" />
                            </div>
                        </div>
                        <div class="md:flex md:items-center mb-6">
                            <div class="md:w-1/3">
                                <InputLabel value="Password (Optional, leave empty to keep unchanged)" />
                            </div>
                            <div class="md:w-2/3">
                                <TextInput v-model="form.password" type="password" class="w-full" />
                                <InputError :message="form.errors.password" />
                            </div>
                        </div>
                        <div class="md:flex md:items-center mb-6">
                            <div class="md:w-1/3"></div>
                            <label class="md:w-2/3 flex items-center gap-2 text-gray-500 font-bold">
                                <Checkbox v-model:checked="form.pick531" />
                                <span class="text-sm">Pick 5-3-1</span>
                            </label>
                        </div>
                        <div class="md:flex md:items-center mb-6">
                            <div class="md:w-1/3"></div>
                            <label class="md:w-2/3 flex items-center gap-2 text-gray-500 font-bold">
                                <Checkbox v-model:checked="form.pickall" />
                                <span class="text-sm">Pick All</span>
                            </label>
                        </div>
                        <div class="md:flex md:items-center mb-6">
                            <div class="md:w-1/3"></div>
                            <label class="md:w-2/3 flex items-center gap-2 text-gray-500 font-bold">
                                <Checkbox v-model:checked="form.admin" />
                                <span class="text-sm">Admin</span>
                            </label>
                        </div>
                        <div class="md:flex md:items-center">
                            <div class="md:w-1/3"></div>
                            <div class="md:w-2/3">
                                <PrimaryButton :disabled="form.processing">Submit</PrimaryButton>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
