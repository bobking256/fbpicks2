<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    x: Array,
});

const weeks = Array.from({ length: 18 }, (_, i) => i + 1);
</script>

<template>
    <Head title="Pick 5-3-1 Season View" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pick 5-3-1 Season View</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="overflow-x-auto">
                    <table class="table table-striped table-condensed text-sm">
                        <thead>
                            <tr>
                                <th class="px-2 py-1">Name</th>
                                <th v-for="w in weeks" :key="w" class="px-2 py-1">Wk{{ w }}</th>
                                <th class="px-2 py-1">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, i) in x" :key="i">
                                <td class="px-2 py-1" align="left">{{ row.name }}</td>
                                <td v-for="w in weeks" :key="w" class="px-2 py-1" align="center">{{ row[w] || '' }}</td>
                                <td class="px-2 py-1" align="right">{{ row[19] }}</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
