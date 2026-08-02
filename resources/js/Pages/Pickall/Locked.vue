<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    rows: Array,
    weekno: Number,
});
</script>

<template>
    <Head title="Pick All" />

    <AppLayout>
        <template #header>
            <h2 class="font-display font-semibold text-xl text-nfl-navy-800 tracking-wide leading-tight">Pick All for Week No. {{ weekno }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="overflow-x-auto">
                    <table class="text-xs sm:text-sm">
                        <thead>
                            <tr class="bg-nfl-navy-800 text-white text-xs uppercase tracking-wide">
                                <th class="sticky left-0 bg-nfl-navy-800 px-3 py-2 text-left">Name</th>
                                <th v-for="n in 16" :key="n" class="px-2 py-2 text-center">P{{ n }}</th>
                                <th class="px-3 py-2 text-right">MNF Total</th>
                                <th class="px-3 py-2 text-right">Yr Tot</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(row, i) in rows"
                                :key="i"
                                class="border-t border-gray-200"
                                :class="i % 2 === 1 ? 'bg-gray-50' : 'bg-white'"
                            >
                                <td class="sticky left-0 px-3 py-1 text-left font-semibold text-nfl-navy-800" :class="i % 2 === 1 ? 'bg-gray-50' : 'bg-white'">{{ row[0] }}</td>
                                <td v-for="n in 16" :key="n" class="px-2 py-1 text-center text-gray-600">{{ row[n] }}</td>
                                <td class="px-3 py-1 text-right">{{ row[17] }}</td>
                                <td class="px-3 py-1 text-right font-semibold text-nfl-navy-800">{{ row[18] }}</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
