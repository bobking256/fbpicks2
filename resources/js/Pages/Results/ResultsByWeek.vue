<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { resultsbyweek } from '@/routes/results';

defineProps({
    res: Array,
    week_no: Number,
});

const weeks = Array.from({ length: 18 }, (_, i) => i + 1);
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
                    Week No.:
                    <template v-for="w in weeks" :key="w">
                        <Link :href="resultsbyweek(w)">{{ w }}</Link>&nbsp;&nbsp;
                    </template>
                    <br /><br />
                    As of Week #{{ week_no }}
                    <br />
                    <table class="table table-auto">
                        <thead>
                            <tr>
                                <th class="px-2 py-1">Name</th>
                                <th class="px-2 py-1">Cummulative Week Total</th>
                                <th class="px-2 py-1">Overall Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(r, i) in res" :key="i">
                                <tr v-if="r.name">
                                    <td class="px-2 py-1">{{ r.name }}</td>
                                    <td class="px-2 py-1">{{ r.weektot || 0 }}</td>
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
