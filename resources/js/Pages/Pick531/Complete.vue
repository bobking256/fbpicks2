<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    weekno: Number,
    teams: Array,
    pick5: Number,
    pick3: Number,
    pick1: Number,
    bonus: Number,
    rembonus: Number,
});

const teamName = (id) => props.teams[id - 1]?.name ?? '';
</script>

<template>
    <Head title="Pick 5-3-1" />

    <AppLayout>
        <template #header>
            <h2 class="font-display font-semibold text-xl text-nfl-navy-800 tracking-wide leading-tight">Pick 5-3-1</h2>
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
                            <p class="text-sm text-gray-500">Your Pick 5-3-1 selections for week {{ weekno }} are in.</p>
                        </div>
                    </div>

                    <ul class="mt-6 divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden">
                        <li class="flex items-center gap-3 px-4 py-3">
                            <span class="flex items-center justify-center size-8 rounded-full bg-nfl-navy-800 text-white text-sm font-bold">5</span>
                            <span class="font-semibold text-nfl-navy-800">{{ teamName(pick5) }}</span>
                        </li>
                        <li class="flex items-center gap-3 px-4 py-3">
                            <span class="flex items-center justify-center size-8 rounded-full bg-nfl-navy-800 text-white text-sm font-bold">3</span>
                            <span class="font-semibold text-nfl-navy-800">{{ teamName(pick3) }}</span>
                        </li>
                        <li class="flex items-center gap-3 px-4 py-3">
                            <span class="flex items-center justify-center size-8 rounded-full bg-nfl-navy-800 text-white text-sm font-bold">1</span>
                            <span class="font-semibold text-nfl-navy-800">{{ teamName(pick1) }}</span>
                        </li>
                        <li v-if="bonus != 0" class="flex items-center gap-3 px-4 py-3">
                            <span class="flex items-center justify-center size-8 rounded-full bg-nfl-red-600 text-white text-xs font-bold">B</span>
                            <span class="font-semibold text-nfl-navy-800">{{ teamName(bonus) }}</span>
                        </li>
                    </ul>

                    <p class="mt-4 text-sm text-gray-500">Remaining bonus pick(s): <span class="font-semibold text-nfl-navy-800">{{ rembonus }}</span></p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
