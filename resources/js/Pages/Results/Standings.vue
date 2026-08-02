<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    standings: Array,
});

const weeks = Array.from({ length: 18 }, (_, i) => i + 1);
</script>

<template>
    <Head title="Pick 5-3-1 Season View" />

    <AppLayout>
        <template #header>
            <h2 class="font-display font-semibold text-xl text-nfl-navy-800 tracking-wide leading-tight">Pick 5-3-1 Season View</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="overflow-x-auto">
                    <table class="text-sm">
                        <thead>
                            <tr class="bg-nfl-navy-800 text-white text-xs uppercase tracking-wide">
                                <th class="sticky left-0 bg-nfl-navy-800 px-3 py-2 text-left">Name</th>
                                <th v-for="w in weeks" :key="w" class="px-2 py-2 text-center">Wk{{ w }}</th>
                                <th class="px-3 py-2 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(row, i) in standings"
                                :key="i"
                                class="border-t border-gray-200"
                                :class="i % 2 === 1 ? 'bg-gray-50' : 'bg-white'"
                            >
                                <td class="sticky left-0 px-3 py-1 text-left font-semibold text-nfl-navy-800" :class="i % 2 === 1 ? 'bg-gray-50' : 'bg-white'">{{ row.name }}</td>
                                <td v-for="w in weeks" :key="w" class="px-2 py-1 text-center text-gray-600">{{ row[w] || '' }}</td>
                                <td class="px-3 py-1 text-right font-semibold text-nfl-navy-800">{{ row[19] }}</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
