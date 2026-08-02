<script setup>
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    res: Array,
});

const rankings = computed(() => props.res.filter((r) => r.name));
</script>

<template>
    <Head title="Pick 5-3-1 Weekly Results" />

    <AppLayout>
        <template #header>
            <h2 class="font-display font-semibold text-xl text-nfl-navy-800 tracking-wide leading-tight">Pick 5-3-1 Weekly Results</h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-nfl-navy-800 text-white text-xs uppercase tracking-wide">
                                <th class="px-4 py-2 text-right">Rank</th>
                                <th class="px-4 py-2 text-left">Name</th>
                                <th class="px-4 py-2 text-right">Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(r, i) in rankings"
                                :key="i"
                                class="border-t border-gray-200"
                                :class="i % 2 === 1 ? 'bg-gray-50' : 'bg-white'"
                            >
                                <td class="px-4 py-2 text-right text-gray-500">{{ i + 1 }}</td>
                                <td class="px-4 py-2 text-left font-semibold text-nfl-navy-800">{{ r.name }}</td>
                                <td class="px-4 py-2 text-right font-semibold text-nfl-navy-800">{{ r.tot }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
