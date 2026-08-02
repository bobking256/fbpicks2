<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    x: Array,
    weekno: Number,
});
</script>

<template>
    <Head title="Pick All" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pick All for Week No. {{ weekno }}</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto overflow-x-auto sm:px-6 lg:px-8 sm:text-xs md:text-xs lg:text-sm">
                <table class="table table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-2 py-1">Name</th>
                            <th v-for="n in 16" :key="n" class="px-2 py-1">P{{ n }}</th>
                            <th class="px-2 py-1">MNF Total</th>
                            <th class="px-2 py-1">Yr Tot</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, i) in x" :key="i">
                            <td v-for="k in 19" :key="k" class="px-2 py-1">{{ row[k - 1] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
