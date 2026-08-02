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
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div v-if="page.props.flash.success" class="mb-4 text-green-700 font-bold px-4">
                    {{ page.props.flash.success }}
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-6">
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
                                    class="w-full rounded border-gray-300 text-gray-700 focus:border-nfl-navy-500 focus:ring-nfl-navy-500"
                                />
                            </div>
                        </div>
                        <div class="md:flex md:items-center mb-6">
                            <div class="md:w-1/3"></div>
                            <label class="md:w-2/3 flex items-center gap-2 text-gray-500 font-bold">
                                <input v-model="form.register" type="checkbox" class="rounded border-gray-300 text-nfl-navy-700 focus:ring-nfl-navy-500" />
                                <span class="text-sm">Allow Registration</span>
                            </label>
                        </div>
                        <div class="md:flex md:items-center">
                            <div class="md:w-1/3"></div>
                            <div class="md:w-2/3">
                                <button
                                    class="font-bold rounded-lg px-4 py-2 text-white bg-nfl-navy-700 hover:bg-nfl-navy-600 disabled:opacity-50 transition"
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
