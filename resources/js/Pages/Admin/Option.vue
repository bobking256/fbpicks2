<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import admin from '@/routes/admin';

const props = defineProps({
    option: Object,
});

const page = usePage();

const form = useForm({
    message: props.option.message,
    register: !!props.option.register,
});

const submit = () => {
    form.put(admin.option.update(props.option.id).url);
};
</script>

<template>
    <Head title="Admin Options" />

    <AppLayout>
        <template #header>
            <h2 class="font-display font-semibold text-xl text-nfl-navy-800 tracking-wide leading-tight">Admin Options</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="page.props.flash.success" class="mb-4 text-green-700 font-bold px-4">
                    {{ page.props.flash.success }}
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-4">
                    <form @submit.prevent="submit">
                        <div class="md:flex md:items-center mb-6">
                            <div class="md:w-1/3">
                                <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="message">
                                    Admin Message
                                </label>
                            </div>
                            <div class="md:w-2/3">
                                <input
                                    id="message"
                                    v-model="form.message"
                                    type="text"
                                    class="bg-gray-200 appearance-none border-2 border-gray-200 rounded-sm w-full py-2 px-4 text-gray-700 leading-tight focus:outline-hidden focus:bg-white focus:border-purple-500"
                                />
                            </div>
                        </div>
                        <div class="md:flex md:items-center mb-6">
                            <div class="md:w-1/3"></div>
                            <label class="md:w-2/3 block text-gray-500 font-bold">
                                <input v-model="form.register" class="mr-2 leading-tight" type="checkbox" />
                                <span class="text-sm">Allow Registration</span>
                            </label>
                        </div>
                        <div class="md:flex md:items-center">
                            <div class="md:w-1/3"></div>
                            <div class="md:w-2/3">
                                <button
                                    class="shadow-sm bg-nfl-navy-700 hover:bg-nfl-navy-600 focus:shadow-outline focus:outline-hidden text-white font-bold py-2 px-4 rounded-sm disabled:opacity-50 transition"
                                    type="submit"
                                    :disabled="form.processing"
                                >
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
