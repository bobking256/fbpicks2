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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pick All</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    Your picks have been saved.
                    <br /><br />
                    <template v-for="(pick, i) in summary.picks" :key="i">
                        <span v-if="pick.label">{{ pick.label }}:</span><br v-if="pick.label" />
                        {{ pick.team }}<br />
                    </template>
                    <br />
                    Total Points: {{ summary.totpts }}
                </div>
            </div>
        </div>
    </AppLayout>
</template>
