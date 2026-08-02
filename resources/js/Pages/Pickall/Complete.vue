<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    summary: Object,
});
</script>

<template>
    <Head title="Pick All" />

    <AppLayout>
        <template #header>
            <h2 class="font-display font-semibold text-xl text-nfl-navy-800 tracking-wide leading-tight">Pick All</h2>
        </template>

        <div class="py-12">
            <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center size-10 rounded-full bg-green-100 text-green-700">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display font-semibold text-lg text-nfl-navy-800 tracking-wide">Picks Saved</h3>
                            <p class="text-sm text-gray-500">Your Pick All selections are in.</p>
                        </div>
                    </div>

                    <ul class="mt-6 divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden">
                        <li v-for="(pick, i) in summary.picks" :key="i" class="flex items-center justify-between gap-3 px-4 py-3">
                            <span class="font-semibold text-nfl-navy-800">{{ pick.team }}</span>
                            <span v-if="pick.label" class="text-xs font-bold uppercase tracking-wide text-nfl-red-600">{{ pick.label }}</span>
                        </li>
                    </ul>

                    <p class="mt-4 text-sm text-gray-500">Total points: <span class="font-semibold text-nfl-navy-800">{{ summary.totpts }}</span></p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
