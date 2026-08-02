<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { emailnotpicked } from '@/routes/pickall';

defineProps({
    users: Array,
});
</script>

<template>
    <Head title="Not Yet Picked All" />

    <AppLayout>
        <template #header>
            <h2 class="font-display font-semibold text-xl text-nfl-navy-800 tracking-wide leading-tight">Not Yet Picked All</h2>
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
                    <button class="bg-nfl-navy-700 text-white font-bold hover:bg-nfl-navy-600 transition px-4 py-2 rounded-lg">
                        Email Not Picked Users
                    </button>
                </a>
            </div>
        </div>
    </AppLayout>
</template>
