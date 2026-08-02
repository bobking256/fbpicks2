<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    res: Array,
});
</script>

<template>
    <Head title="Pick 5-3-1 Weekly Results" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pick 5-3-1 Weekly Results</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="table table-auto">
                        <thead>
                            <tr>
                                <th class="px-2 py-1">Name</th>
                                <th class="px-2 py-1">Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(r, i) in res" :key="i">
                                <tr v-if="r.name">
                                    <td class="px-2 py-1">{{ r.name }}</td>
                                    <td class="px-2 py-1">{{ r.tot }}</td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
