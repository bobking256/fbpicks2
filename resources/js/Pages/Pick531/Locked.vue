<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    x: Array,
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
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-4">
                    <div class="overflow-x-auto">
                    <table class="table table-striped table-condensed">
                        <thead>
                            <tr>
                                <th class="px-4 py-1">Name</th>
                                <th class="px-4 py-1">5 Pt</th>
                                <th class="px-4 py-1">3 Pt</th>
                                <th class="px-4 py-1">1 Pt</th>
                                <th class="px-4 py-1">Bonus</th>
                                <th class="px-4 py-1">Bonus Remaining</th>
                                <th class="px-4 py-1">Total Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, i) in x" :key="i">
                                <td v-for="(cell, k) in row" :key="k" class="px-4 py-1">{{ cell }}</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
