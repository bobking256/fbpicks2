<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    rows: Array,
    weekno: Number,
});
</script>

<template>
    <Head title="Pick 5-3-1" />

    <AppLayout>
        <template #header>
            <h2 class="font-display font-semibold text-xl text-nfl-navy-800 tracking-wide leading-tight">Pick 5-3-1 for Week No. {{ weekno }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-nfl-navy-800 text-white text-xs uppercase tracking-wide">
                                <th class="px-4 py-2 text-left">Name</th>
                                <th class="px-4 py-2 text-center">5 Pt</th>
                                <th class="px-4 py-2 text-center">3 Pt</th>
                                <th class="px-4 py-2 text-center">1 Pt</th>
                                <th class="px-4 py-2 text-center">Bonus</th>
                                <th class="px-4 py-2 text-center">Bonus Remaining</th>
                                <th class="px-4 py-2 text-right">Total Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(row, i) in rows"
                                :key="i"
                                class="border-t border-gray-200"
                                :class="i % 2 === 1 ? 'bg-gray-50' : 'bg-white'"
                            >
                                <td class="px-4 py-2 text-left font-semibold text-nfl-navy-800">{{ row[0] }}</td>
                                <td class="px-4 py-2 text-center">{{ row[1] }}</td>
                                <td class="px-4 py-2 text-center">{{ row[2] }}</td>
                                <td class="px-4 py-2 text-center">{{ row[3] }}</td>
                                <td class="px-4 py-2 text-center">{{ row[4] }}</td>
                                <td class="px-4 py-2 text-center">{{ row[5] }}</td>
                                <td class="px-4 py-2 text-right font-semibold text-nfl-navy-800">{{ row[6] }}</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
