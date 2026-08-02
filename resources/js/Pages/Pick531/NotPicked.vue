<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { emailnotpicked } from '@/routes/pick531';

defineProps({
    users: Array,
});
</script>

<template>
    <Head title="Not Yet Picked 5-3-1" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Not Yet Picked 5-3-1</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="table table-auto">
                        <thead>
                            <tr>
                                <th class="px-4 py-1">Name</th>
                                <th class="px-4 py-1">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="u in users" :key="u.id">
                                <td class="px-4 py-1">{{ u.name }}</td>
                                <td class="px-4 py-1">{{ u.email }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                <a :href="emailnotpicked().url">
                    <button class="bg-red-200 font-bold hover:bg-red-500 px-4 py-2 border-2 border-gray-400 rounded-lg">
                        Email Not Picked Users
                    </button>
                </a>
            </div>
        </div>
    </AppLayout>
</template>
