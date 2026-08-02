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
            <h2 class="font-display font-semibold text-xl text-nfl-navy-800 tracking-wide leading-tight">Not Yet Picked 5-3-1</h2>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-nfl-navy-800 text-white text-xs uppercase tracking-wide">
                                <th class="px-4 py-2 text-left">Name</th>
                                <th class="px-4 py-2 text-left">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(u, i) in users"
                                :key="u.id"
                                class="border-t border-gray-200"
                                :class="i % 2 === 1 ? 'bg-gray-50' : 'bg-white'"
                            >
                                <td class="px-4 py-2 text-left font-semibold text-nfl-navy-800">{{ u.name }}</td>
                                <td class="px-4 py-2 text-left text-gray-600">{{ u.email }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 mt-4">
                <a
                    :href="emailnotpicked().url"
                    class="inline-block bg-nfl-navy-700 text-white font-bold hover:bg-nfl-navy-600 transition px-4 py-2 rounded-lg"
                >
                    Email Not Picked Users
                </a>
            </div>
        </div>
    </AppLayout>
</template>
