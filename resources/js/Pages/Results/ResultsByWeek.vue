<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { resultsbyweek } from '@/routes/results';

const props = defineProps({
    res: Array,
    week_no: Number,
});

const weeks = Array.from({ length: 18 }, (_, i) => i + 1);
const rankings = computed(() => props.res.filter((r) => r.name));
</script>

<template>
    <Head title="Pick 5-3-1 Results By Week No." />

    <AppLayout>
        <template #header>
            <h2 class="font-display font-semibold text-xl text-nfl-navy-800 tracking-wide leading-tight">Pick 5-3-1 Results By Week No.</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex flex-wrap items-center gap-1">
                        <span class="font-semibold text-nfl-navy-800 mr-1">Week:</span>
                        <Link
                            v-for="w in weeks"
                            :key="w"
                            :href="resultsbyweek(w)"
                            class="flex items-center justify-center size-7 rounded text-sm font-semibold transition"
                            :class="w === week_no ? 'bg-nfl-navy-800 text-white' : 'text-nfl-navy-800 hover:bg-gray-100'"
                        >
                            {{ w }}
                        </Link>
                    </div>

                    <p class="mt-4 text-sm text-gray-500">As of week #{{ week_no }}</p>

                    <table class="mt-2 w-full text-sm">
                        <thead>
                            <tr class="bg-nfl-navy-800 text-white text-xs uppercase tracking-wide">
                                <th class="px-4 py-2 text-right">Rank</th>
                                <th class="px-4 py-2 text-left">Name</th>
                                <th class="px-4 py-2 text-right">Week Total</th>
                                <th class="px-4 py-2 text-right">Overall Total</th>
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
                                <td class="px-4 py-2 text-right">{{ r.weektot || 0 }}</td>
                                <td class="px-4 py-2 text-right font-semibold text-nfl-navy-800">{{ r.tot }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
