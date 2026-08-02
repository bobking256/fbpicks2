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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pick 5-3-1</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    Your picks have been saved. You selected:
                    <br /><br />
                    <ul>
                        <li>5 pts - {{ teamName(pick5) }}</li>
                        <li>3 pts - {{ teamName(pick3) }}</li>
                        <li>1 pts - {{ teamName(pick1) }}</li>
                        <li v-if="bonus != 0">Bonus - {{ teamName(bonus) }}</li>
                    </ul>
                    <br />
                    Remaining Bonus Pick(s): {{ rembonus }}
                </div>
            </div>
        </div>
    </AppLayout>
</template>
